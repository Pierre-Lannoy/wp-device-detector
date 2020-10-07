APCu Manager is fully usable from command-line, thanks to [WP-CLI](https://wp-cli.org/). You can set APCu Manager options and much more, without using a web browser.

1. [Obtaining statistics about APCu usage](#obtaining-statistics-about-device-usage) - `wp device analytics`
2. [Getting APCu Manager status](#getting-device-manager-status) - `wp device status`
3. [Managing main settings](#managing-main-settings) - `wp device settings`

## Obtaining statistics about APCu usage

You can get APCu analytics for today (compared with yesterday). To do that, use the `wp device analytics` command.

By default, the outputted format is a simple table. If you want to customize the format, just use `--format=<format>`. Note if you choose `json` as format, the output will contain full data and metadata for the current day.

### Examples

To list the loggers, type the following command:
```console
pierre@dev:~$ wp device analytics
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

## Getting APCu Manager status

To get detailed status and operation mode, use the `wp device status` command.

> Note this command may tell you APCu is not activated for command-line even if it's available for WordPress itself. It is due to the fact that PHP configuration is often different between command-line and web server.
>
> Nevertheless, if APCu is available for WordPress, other APCu Manager commands are operational.

## Managing main settings

To toggle on/off main settings, use `wp device settings <enable|disable> <gc|analytics>`.

If you try to disable a setting, wp-cli will ask you to confirm. To force answer to yes without prompting, just use `--yes`.

### Available settings

- `gc`: garbage collection feature
- `analytics`: analytics feature

### Example

To disable garbage collection without confirmation prompt, type the following command:
```console
pierre@dev:~$ wp device settings disable gc --yes
Success: garbage collection is now deactivated.
```
