Put your real bundle ZIP files here, e.g.:
  hifi11-bundle-v1.0.zip

Then make sure the matching `bundle_versions.file_path` column in the
database contains just the filename (relative to this folder), e.g.
"hifi11-bundle-v1.0.zip" — NOT a URL and NOT "downloads/...".

This directory must sit OUTSIDE your web server's document root.
In this project's default layout that means: one level above the
folder that contains index.php/checkout.php/etc. If your host's
control panel forces everything to live under public_html/, create
this folder as a *sibling* of public_html (not inside it) and update
SECURE_STORAGE_PATH in config/config.php to point at it with an
absolute path.
