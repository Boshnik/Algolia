# Algolia

**Algolia** is a powerful cloud-based search platform that provides instant and relevant search results.

### Setup

1. **Register on Algolia**  
   Sign up on [Algolia](https://www.algolia.com/) and obtain your [API keys](https://dashboard.algolia.com/account/api-keys/).

2. **Configure in MODX**  
   Go to MODX system settings and specify:
    - **Application ID** (`algolia.app_id`)
    - **Admin API Key** (`algolia.api_key`)

3. **Create an Index**  
   Create an index in Algolia and specify its name in the system setting `algolia.index_name`.

   ![Creating an Index](https://file.modx.pro/files/c/1/8/c1847e82a9698e8f7f992832025e9e7f.jpg)  
   *The image shows how to navigate to the search panel and create an index.*

4. **Configure Searchable Fields**  
   Specify the fields to be included in the search in the setting `algolia.searchable_fields`.  
   Default: `alias,pagetitle,longtitle,description,introtext`.

5. **Configure Fields for Output**  
   Specify the fields to be returned in search results in the setting `algolia.fields_to_retrieve`.  
   Default: `alias,pagetitle,longtitle,description,introtext`.

### Configuring Data for Indexing

1. **Select Resource Type**  
   Specify the resource type in the setting `algolia.class_key`:
    - **modDocument** (regular resources)
    - **msProduct** (miniShop2 products)
    - **pbResource** (PageBlocks collections)

2. **Fields for Indexing**  
   Specify the fields to be sent to the index in the setting `algolia.fields`.  
   Default: `alias,pagetitle,longtitle,description,introtext`.

3. **Additional Conditions**  
   Specify additional conditions for data selection in JSON format in the setting `algolia.where`.  
   Examples:
   ```php
   [{"parent": 5}] // add only resources with parent ID 5 to the index
   [{"price:>": 0}] // add products with a price greater than 0

   // Example for PageBlocks
   [{"field_name": "name"}] // in developer mode
   [{"collection_id": 1}] // in manager mode
   ```

### Usage

After installing the component, resources will be automatically indexed when updated. You can also force an index update through the component menu, where you can also delete all data from the index.

#### Search Form

To display the search form, you don’t need to use a snippet. Simply insert the HTML code, for example:
```html
<form class="d-flex" role="search" method="get" action="[[~187]]"> <!-- 187 — search results page -->
    <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button>
</form>
```

#### Displaying Search Results

On the search results page, place the **AlgoliaResult** snippet with the following parameters:
- **paramSearch** — name of the search parameter. Default: `query`.
- **tpl** — chunk for wrapping results. Default: `algolia.result`.
- **tpl.result.item** — chunk for displaying a single result. Default: `algolia.result.item`.
- **tpl.result.empty** — chunk for displaying "no results found". Default: `algolia.result.empty`.
- **tpl.pagination** — chunk for pagination. Default: `algolia.pagination`.
- **tpl.pagination.item** — chunk for a pagination item. Default: `algolia.pagination.item`.
- **limit** — number of results per page. Default: `10`.
- **outputSeparator** — separator for results. Default: `\n`.
- **toPlaceholder** — output results to a placeholder. Default: `false`.