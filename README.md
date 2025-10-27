# Security Headers Plugin for OJS

This plugin enhances the security of your OJS installation by adding a comprehensive set of modern HTTP security headers. It operates with "**default with override**" logic, providing robust security out-of-the-box while allowing customization for specific needs.
This plugin is developed and maintained by Ashvisual Theme. <a href="https://demo-ojs.ashvisual.com" target="_blank">See our professional OJS themes in action on our live demo</a>.

## Key Features

- 🛡️ **Adds Modern Security Headers:** Implements best practices to protect your site from common attacks like clickjacking, XSS, and MIME-sniffing.
- ⚙️ **Secure Defaults:** Comes with recommended default values for all headers, so you don't need to configure anything unless required.
- ✍️ **Flexible Customization:** Allows administrators to override the value of each header for the entire site or for individual journals.
- 🗑️ **Removes `X-Powered-By` Header:** Hides server technology information to reduce the informational footprint.

### Managed Headers

This plugin manages the following headers:

- `X-Frame-Options`
- `X-Content-Type-Options`
- `X-XSS-Protection` (Included for compatibility, though deprecated)
- `Content-Security-Policy`
- `Cross-Origin-Embedder-Policy`
- `Cross-Origin-Opener-Policy`
- `Cross-Origin-Resource-Policy`
- `Permissions-Policy`
- `Referrer-Policy`
- `Strict-Transport-Security`

---

## Requirements

- **OJS version:** 3.5.x (eg. `3.5.0.0` `3.5.0.1`)

---

## Installation

1.  Download the latest release from the plugin's release page.
2.  Log in to your OJS dashboard as an Administrator.
3.  Navigate to **Website Settings > Plugins > Upload a New Plugin**.
4.  Upload the `.tar.gz` file you downloaded.
5.  Once installation is complete, enable the plugin from the **Installed Plugins** tab.

---

## Configuration

You can configure custom header values for your site or for a specific journal.

1.  Navigate to **Website Settings > Plugins**.
2.  Find the **Security Headers by AshVisual Theme** plugin and click the **Settings** button.
3.  A modal window will appear with all configurable headers. The fields will be pre-filled with the secure default values.
4.  To change a header, edit its value in the corresponding field.
5.  To **disable** a specific header, clear its field so it is empty and then save. The other headers will remain active with their default or custom values.
6.  Click **Save**.

---

## Verifying the Headers

After configuring the plugin, you can verify that the security headers are being applied correctly using a free online tool.

1.  Go to a site like [**securityheaders.com**](https://securityheaders.com).
2.  Enter the URL of your journal (e.g., `https://myjournal.com`).
3.  Initiate the scan.
4.  The results will show you which HTTP security headers are active on your site. You should see the headers enabled by this plugin listed in the report.

This will help you confirm that your configuration is working as expected.

---

### Default Values

If a header's value is not customized (or the settings have never been saved), the plugin applies the following secure default values:

| Header                       | Default Value                                                                                                          |
| :--------------------------- | :--------------------------------------------------------------------------------------------------------------------- |
| X-Frame-Options              | `SAMEORIGIN`                                                                                                           |
| X-Content-Type-Options       | `nosniff`                                                                                                              |
| X-XSS-Protection             | `1; mode=block`                                                                                                        |
| Content-Security-Policy      | `upgrade-insecure-requests;`                                                                                           |
| Cross-Origin-Embedder-Policy | `same-origin; report-to='default'`                                                                                     |
| Cross-Origin-Opener-Policy   | `require-corp`                                                                                                         |
| Cross-Origin-Resource-Policy | `same-origin`                                                                                                          |
| Permissions-Policy           | `accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), usb=(), fullscreen=(self)` |
| Referrer-Policy              | `strict-origin-when-cross-origin`                                                                                      |
| Strict-Transport-Security    | `max-age=63072000; includeSubDomains; preload`                                                                         |

---

## License

This plugin is released under the GNU General Public License v3. See the `LICENSE.md` or `docs/COPYING` file for full terms.
