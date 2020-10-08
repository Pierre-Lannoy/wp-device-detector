APCu Manager is fully usable from command-line, thanks to [WP-CLI](https://wp-cli.org/). You can set APCu Manager options and much more, without using a web browser.

1. [Obtaining statistics about devices](#obtaining-statistics-about-device-usage) - `wp device analytics`
2. [Describing a device](#describing-a-device) - `wp device describe`
3. [Getting informations about the detector engine](#getting-informations-about-the-detector-engine) - `wp device engine`
4. [Getting Device Detector status](#getting-device-detector-status) - `wp device status`
5. [Managing main settings](#managing-main-settings) - `wp device settings`
6. [Misc flags](#misc-flags)

## Obtaining statistics about devices

You can get devices analytics for today (compared with yesterday). To do that, use the `wp device analytics` command.

If you're in a multisite environment, use `--site=<site_id>` to specify which site you want to get. 

By default, the outputted format is a simple table. If you want to customize the format, just use `--format=<format>`. Note if you choose `json` or `yaml` as format, the output will contain full data and metadata for the current day.

### Examples

To display devices statistics for site id 5, type the following command:
```console
pierre@dev:~$ wp device analytics --site=5
+-------------+-----------------------------+-------+--------+-----------+
| kpi         | description                 | value | ratio  | variation |
+-------------+-----------------------------+-------+--------+-----------+
| Hits Number | Number of hits.             | 1.5K  | -      | -26.06%   |
| Mobile      | Hits done by mobiles.       | 0     | 0%     | 0%        |
| Desktop     | Hits done by desktops.      | 42    | 2.76%  | -52.67%   |
| Bot         | Hits done by bots.          | 373   | 24.52% | +6.65%    |
| Clients     | Number of distinct clients. | 3     | -      | -40%      |
| Engines     | Number of distinct engines. | 2     | -      | 0%        |
+-------------+-----------------------------+-------+--------+-----------+
```

## Describing a device

To obtain the detail of a device, based on its _user-agent_ string, use the `wp device describe <ua>` command, where `<ua>` is the _user-agent_ string.

By default, the outputted format is a simple table. If you want to customize the format, just use `--format=<format>`. Note if you choose `json` or `yaml` as format, the output will contain full data and metadata regarding the device.

### Examples

To display the detail of a device having the _user-agent_ string "Mozilla/5.0 (iPhone; CPU iPhone OS 11_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko)", type the following command:
```console
pierre@dev:~$ wp device describe 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko)'
+----------+-----------------+
| key      | value           |
+----------+-----------------+
| class    | Mobile          |
| type     | Smartphone      |
| brand    | Apple           |
| model    | iPhone          |
| client   | Browser         |
| name     | Mobile Safari   |
| engine   | WebKit 603.1.30 |
| os       | iOS 11.3.1      |
| platform |                 |
+----------+-----------------+
```

## Getting informations about the detector engine

As you know, Device Detector is based on the Matomo UDD engine. To obtain informations about this engine, you can use the `wp device engine <version|info|class|device|client|os|browser|engine|library|player|app|pim|reader|brand|bot>` command.

The main informations you can display are:

- `version`: version of integrated UDD.
- `info`: details about engine.
- `class|device|client|os|browser|engine|library|player|app|pim|reader|brand|bot`: detectable items.

### Examples

To display all the detectable bots, type the following command:
```console
pierre@dev:~$ wp device engine bot
+-------------------------------------+
| bot                                 |
+-------------------------------------+
| 360Spider                           |
| Aboundexbot                         |
| Acoon                               |
| AddThis.com                         |
| aHrefs Bot                          |
| Alexa Crawler                       |
| Alexa Site Audit                    |
| Amazon Route53 Health Check         |
| Amorank Spider                      |
| ApacheBench                         |
| Applebot                            |
| Arachni                             |
...
| GTmetrix                            |
| Nutch-based Bot                     |
| Seobility                           |
| Generic Bot                         |
+-------------------------------------+
```

## Getting Device Detector status

To get detailed status and operation mode, use the `wp device status` command.

## Managing main settings

To toggle on/off main settings, use `wp device settings <enable|disable> <analytics>`.

If you try to disable a setting, wp-cli will ask you to confirm. To force answer to yes without prompting, just use `--yes`.

### Available settings

- `analytics`: analytics feature

### Example

To disable analytics without confirmation prompt, type the following command:
```console
pierre@dev:~$ wp device settings disable analytics --yes
Success: analytics are now deactivated.
```

## Misc flags

For most commands, APCu Manager lets you use the following flags:
- `--yes`: automatically answer "yes" when a question is prompted during the command execution.
- `--stdout`: outputs a clean STDOUT string so you can pipe or store result of command execution.

> It's not mandatory to use `--stdout` when using `--format=count` or `--format=ids`: in such cases `--stdout` is assumed.

> Note Device Detector sets exit code so you can use `$?` to write scripts.
> To know the meaning of Device Detector exit codes, just use the command `wp device exitcode list`.