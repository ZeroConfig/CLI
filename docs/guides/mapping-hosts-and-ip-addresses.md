# Mapping hosts and IP addresses

The following is an example implementation to get a list of active network
interfaces. For each interface, it shows a list of IPv4 and IPv6 addresses,
along with the host name resolved from that IP address.

Note: this example only works on systems with the `ifconfig` program installed.

```php
#!/usr/bin/env php
<?php
use ZeroConfig\Cli\Reader\CallbackResource;
use ZeroConfig\Cli\Transformer\Callback\CallbackTransformer;
use ZeroConfig\Cli\Writer\StandardOut;

// Read all interfaces on the host operating system.
$reader = new CallbackResource(
    function () : iterable {
        $handle    = popen('ifconfig', 'r');
        $interface = '';

        while (!feof($handle)) {
            $line = trim(fgets($handle));

            if (empty($line)) {
                if (empty($interface)) {
                    continue;
                }

                yield $interface;
                $interface = '';
                continue;
            }

            $interface .= $line . PHP_EOL;
        }

        if (!empty($interface)) {
            yield $interface;
        }

        pclose($handle);
    }
);

// Map the interfaces with their IP addresses and the host names corresponding
// to those IP addresses, leaving out interfaces that aren't connected.
$mapper = new CallbackTransformer(
    function (iterable $interfaces) : iterable {
        foreach ($interfaces as $interface) {
            $config         = explode(PHP_EOL, $interface);
            $identification = array_shift($config);
            [$name]         = explode(':', $identification, 2);
            $ips            = [];

            foreach ($config as $configEntry) {
                if (preg_match(
                    '#^inet6?\s(?P<ip>\S+)#',
                    $configEntry,
                    $matches
                )) {
                    $ips[] = sprintf(
                        "%2\$s:\t%1\$s",
                        $matches['ip'],
                        gethostbyaddr($matches['ip'])
                    );
                }
            }

            if (!empty($name) && !empty($ips)) {
                yield sprintf(
                    "%s:\n\t%s\n\n",
                    $name,
                    implode("\n\t", $ips)
                );
            }
        }
    }
);

$writer = new StandardOut();

// Read interfaces > Map IP and hostname > Write to STDOUT.
$writer($mapper($reader));
```

The following is an example output:

```
docker0:
        kirito: 172.17.0.1
        kirito: fe80::42:6eff:fe0b:abff

lo:
        localhost:      127.0.0.1
        ip6-localhost:  ::1

wlp4s0:
        kirito: 192.168.2.14
        kirito: fe80::4c3a:5511:26ce:78da
```

# Further reading

- [Callback resource](../input/callback.md)
- [Callback transformer](../transformers/callback/callback.md)
