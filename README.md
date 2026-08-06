# The Boies Group WordPress Theme

Custom classic WordPress theme for the ANEE / Boies Group public site. WordPress remains the content-management layer, while the public-facing homepage, research network, publications feed, navigation, and footer are implemented by the theme.

## Research graph

The interactive Research page reads committed JSON generated from the shared Obsidian vault. OneDrive is not required at runtime.

Regenerate the graph after the vault changes:

```sh
npm run build:research -- "/full/path/to/ANEE_Lab_Management_Vault"
```

The generator intentionally exports relationships and public-safe summaries only. It does not publish private member notes from the vault.

## Publications

`/boies-publications/` uses the same BibBase/Mendeley feed as the existing production site. The compatibility `/publications/` template renders the same feed.

## Deployment

The WordPress.com staging site is connected to the GitHub repo. Push to `main`, then let WordPress.com Deployments copy the theme files.

After deployment:

1. Go to `Appearance > Themes`.
2. Activate `The Boies Group`.
3. Go to `Appearance > Customize > Site Identity` to change the header logo.
4. Go to `Appearance > Customize > Boies Group Homepage` to edit the hero video URL, hero text, goals, capabilities, research teaser, imagery, and contact email.
5. Use `Appearance > Menus` to update the top nav if you want a real Capabilities page instead of the homepage section link.

People profiles, Patents, and standard page bodies remain editable in the normal WordPress page editor. The live People page normalizes those editable profile blocks into a stable responsive directory, regardless of how older blocks were nested. Research and Publications use dedicated data-backed templates.
