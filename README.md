sng-data
========

# Data of all artworks in SNG

## 1. SNG-metadata.csv: initial SNG data

### 2. parse_csv_to_json.php - converts SNG csv into JSON

* input: SNG-metadata.csv
* output: SNG-metadata.json - JSON formated data


### 3a. download_thumbs.php - this should be executed just once, downloads thumbnails from SNG and saves filtered JSON

* input: SNG-metadata.json
* output: SNG-metadata-with-thumbs.json - filtered data containing just those which have thumbnail avialable, and thumbnail files stored in folder "thumbs"

### 3b. downloader.php - re-download, using filtered JSON (if we want to download different size of thumbnails)

* input: SNG-metadata-with-thumbs.json
* output: redownloaded thumbnails


### 4. generate_histogram.php - processes saved thumbnails retrieving histagram from them

* input: SNG-metadata-with-thumbs.json, thumbnail images in folder thumbs
* output: JSON files in histogram folder, naming convention is same as naming convention with images. Each file contains luma, red, green, blue histogram
* histogram array contains luma, red, green, blue histagram data for each artwork. indices/keys are color values - 32rd element in [histagram][red] contains percentage of red color with value 32 in image. So [histagram][red][32]=3.59 means that 3.59% of all pixels in image contains red color with value 32.