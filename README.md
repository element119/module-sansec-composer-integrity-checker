<h1 align="center">element119 | Sansec Composer Integrity Checker</h1>

## 📝 Features
✔️ Identify potentially unwanted changes made to your project dependencies 

✔️ Email notifications for packages that do not meet your desired integrity rating

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

### Enable/Disable Scanning
The Sansec Composer integrity scan can be disabled by setting this option to `No`. This is set to `Yes` by default.

<br>

### Report Integrity Failures by Email
Allow emails to be sent when the Sansec Composer integrity checker finds discrepancies with your dependency files.
This feature is disabled by default but can be enabled by setting this option to `Yes`. Once enabled you will be able
to configure a threshold for dependency matching as well as a list of email address to notify when a failure occurs.

<br>

### Match Percentage Threshold for Notification
This option is only considered when integrity failure emails are enabled. The value specified here determines the
minimum match percentage required for the integrity checks to be considered successful. Admins will be notified of any
packages that fail to meet this number. 

<br>

### Report Errors To
This option is only considered when integrity failure emails are enabled. These dynamic rows allow you to configure a
series of email addresses that should be notified when packages fail to meet the configured threshold.

<br>

## 📸 Screenshots & GIFs
### Admin Configuration
![admin-config](https://user-images.githubusercontent.com/40261741/234102715-ed9e584e-da61-4a0f-9ae3-9f72bdde5524.png)

<br>

### Example Email Notification
![email-example](https://user-images.githubusercontent.com/40261741/234102797-8937df5a-7312-4750-a9ca-09c2ad7379bd.png)
