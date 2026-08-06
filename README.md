# The Boies Group WordPress Theme

Custom classic WordPress theme for the ANEE / Boies Group public site. WordPress remains the content-management layer, while the public-facing homepage, research network, publications feed, navigation, and footer are implemented by the theme.

## Research network

The interactive Research page is managed entirely in WordPress. Go to `Research Network` in WordPress Admin to edit its three record types:

- `Research Themes`: title, public description, display order, Featured Image, and image focal position.
- `Research Projects`: title, pop-down description, display order, and connected themes.
- `Researchers`: name, optional public People-profile URL, and connected themes/projects.

The theme exposes those records through the read-only `/wp-json/boies/v1/research-network` endpoint. The current network is seeded once after deployment so the first WordPress edit can start from the existing content. After that import, WordPress is the only source of truth; no JSON generation or Obsidian export is needed.

## Publications

`/boies-publications/` uses the same BibBase/Mendeley feed as the existing production site. The compatibility `/publications/` template renders the same feed.

## Deployment

The WordPress.com staging site is connected to the GitHub repo. Push to `main`, then let WordPress.com Deployments copy the theme files.

After deployment:

1. Go to `Appearance > Themes`.
2. Activate `The Boies Group`.
3. Go to `Appearance > Customize > Site Identity` to change the header logo.
4. Go to `Appearance > Customize > Boies Group Homepage` to edit the hero video URL, hero text, goals, capabilities, research teaser, imagery, and contact email.
5. Open `Research Network` to maintain the public research map, including theme imagery, project descriptions, and researcher links.
6. Use `Appearance > Menus` to update the top nav if you want a real Capabilities page instead of the homepage section link.

People profiles, Patents, and standard page bodies remain editable in the normal WordPress page editor. The live People page normalizes those editable profile blocks into a stable responsive directory, regardless of how older blocks were nested. Publications retains its dedicated feed template, while Research is generated from the WordPress-managed network records.
