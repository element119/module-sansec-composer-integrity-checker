<h1 align="center">element119 | Sansec Composer Integrity Checker</h1>

## 📝 Features
✔️ Identify potentially unwanted changes made to your project dependencies using the [Sansec Composer integrity plugin](https://github.com/sansecio/composer-integrity-plugin)

✔️ Email and admin notifications for packages that do not meet your desired integrity rating

✔️ Supports Magento Open Source and Adobe Commerce

✔️ Theme agnostic

✔️ Dedicated module configuration section secured with custom admin user controls

✔️ Seamless integration with Magento

✔️ Built with developers and extensibility in mind to make customisations as easy as possible

✔️ Installable via Composer

<br/>

## 🔌 Installation
Run the following command to *install* this module:
```bash
composer require element119/module-sansec-composer-integrity-checker
php bin/magento setup:upgrade
```

It is also recommended that you enable the scans and lock the related config value as a post-installation step:
```bash
php bin/magento config:set --lock-env system/sansec_composer_integrity_checker/scan_enable 1
```

<br/>

## ⏫ Updating
Run the following command to *update* this module:
```bash
composer update element119/module-sansec-composer-integrity-checker
php bin/magento setup:upgrade
```

<br/>

## ❌ Uninstallation
Run the following command to *uninstall* this module:
```bash
composer remove element119/module-sansec-composer-integrity-checker
php bin/magento setup:upgrade
```

<br/>

## 📚 User Guide
Configuration for this module can be found in the Magento admin under `Stores -> Settings -> Configuration -> Advanced
-> System -> Sansec Composer Integrity Checker`

<br>

### Scan Results Grid
The results of the most recent scan can be seen in the admin by navigating to `Reports -> Sansec Composer
Integrity Checker -> Integrity Status`.

<br>

### Enable/Disable Scanning
The Sansec Composer integrity scan can be disabled by setting this option to `No`. This is set to `Yes` by default.

<br>

### Match Percentage Threshold for Notification
This option is only considered when integrity failure emails are enabled. The value specified here determines the
minimum match percentage required for the integrity checks to be considered successful. Admins will be notified of any
packages that fail to meet this number.

<br>

### Report Integrity Failures by Email
Allow emails to be sent when the Sansec Composer integrity checker finds discrepancies with your dependency files.
This feature is disabled by default but can be enabled by setting this option to `Yes`. Once enabled you will be able
to configure a threshold for dependency matching as well as a list of email address to notify when a failure occurs.

<br>

### Report Errors To
This option is only considered when integrity failure emails are enabled. These dynamic rows allow you to configure a
series of email addresses that should be notified when packages fail to meet the configured threshold.

<br>

## 📸 Screenshots & GIFs
### Admin Configuration
![admin-config](https://user-images.githubusercontent.com/40261741/234102715-ed9e584e-da61-4a0f-9ae3-9f72bdde5524.png)

<br>

### Admin Grid
![admin-grid](https://user-images.githubusercontent.com/40261741/234440974-3ff17d18-faa0-407b-9b25-0e7e76e7d8aa.png)

<br>

### Admin Notification
![admin-notification](https://user-images.githubusercontent.com/40261741/234434736-0e187e19-f474-47cd-804b-7f4d150ba31b.png)

<br>

### Example Email Notification
![email-example](https://user-images.githubusercontent.com/40261741/234102797-8937df5a-7312-4750-a9ca-09c2ad7379bd.png)
