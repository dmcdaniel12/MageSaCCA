# MageSaCCA
**MageSaCCA** means Magento Sales and Clearance Category Automation

This program is used to automatically update your Sales and Clearance categories automatically. This can be used in two different ways currently, with a third on the way. 

## Installation

Very simple installation instructions. Download the code and edit the lib/Mysql.php file to include your own MySQL code. This is required to pull the information
from the database to create the items that will go into the sale tab. We put anything into the Sale tab that has a lower Special Price than the actual price. We put everything into clearance
where the Special Price is 50% of the regular price. You can change this in the selectClearanceQuery() section of the code. 

## Configuration

Configuration of any system can be complex, but I have tried to make it as easy and simple as possible. Here I will list all of the things you can configure within the configuration
section of the sale.php file using lib/Config. use $config->setNameOfConfiguration() to adjust the default values to your needs. 

* saleBaseCat - Default Sales Category in your admin panel
* cleareanceBaseCat - Default Clearance Category in your admin panel
* csvFileConversion - Default csv file used for conversion for sub categories in saleBaseCat section. 
* clearanceAmount - Set the default percent needed to qualify as a clearance product
* saleCats - If not using the csvFileConversion, you can create an array of saleCats to use for conversion here
* baseCategoryIds - These are your top level baseCategoryIds. Used with saleCats to help w/ conversion
* insertType - default array of mysql, rapidflow and API. DO NOT CHANGE if you want things to stay default. You will use $type = $config->getInsertType(#) to determine what type of insertType the system will use. Default is 0 (SQL). 1 is RapidFlow - will export to CSV file, 2 is API (Not completed yet so wont work). 
* parseType - This will determine whether or not you use csvFileConversion or the saleCats/baseCategoryIds. 0 for array, 1 for CSV. array is default
* excludeSaleOfDayItems - Will determine if you are using our module when it is released. Default is false. 
* magentoAppLocation - Maybe the most important of all. As things progress and switch, you will be required to set this. I have it set to the default currently, which shouldn't need to be changed. It will automatically adjust for Linux/Windows when needed using ROOT Location and Directory_structure. 

## Usage

To use, fill out the lib/Mysql.php file with all of your database credentials. You will also need to fill out the lib/Config.php file with your Sale Category id's, your baseCategoryIds
and your saleCatIds a second time. 

Right now we only have support for MySQL insertion and Rapidflow download CSV file. If you do not feel comfortable having this touch the DB directly, 
then have it export to CSV file for Rapidflow insertion. We are working on an API version so that this will still use the API to change categories in 
the future. 

## Future TODO

Note: These are in no particular order. As I get them completed, I will strike them off the list. 

* ~~Automatically run index once completed~~
* Better support for sites w/ unique category configurations
* ~~Allow people to set their own clearance amount in the config section~~
* Add in API handling of updated categories for smaller projects or people who are uncomfortable editing MySQL with a script directly. 
* ~~Add in Daily Deal code for our own personal usage. We will be releasing this module to public soon.~~
* ~~Config to turn off above bullet point~~
* ~~Complete New Arrivals piece~~
* ~~Create Auto Loader~~
* Update README w/ a proper history
* Pull items from Magento via proper channels w/ Mage

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add Some Feature Comment'`
4. Push to the branch `git push origin -my-new-feature`
5. Submit a pull request :D

## History

This project was started in October of 2015 because I was unable to do this within Magento in a timely manner without taking multiple hours. We have over 300k products 
and to run through this was taking over 12 hours within Magento. This was made in direct response to the amount of time it was taking, especially since we are running this 
daily and updating products daily with our ERP system. 

## License

TODO: Write License information

## Contact

#### Developer/Company

* e-mail: dmcdaniel12@gmail.com
* Twitter: [@dmcdaniel12](https://twitter.com/dmcdaniel12 "dmcdaniel12 on twitter")

