# MageSaCCA
**MageSaCCA** means Magento Sales and Clearance Category Automation

This program is used to automatically update your Sales and Clearance categories automatically. This can be used in two different ways currently, with a third on the way. 

## Installation

Very simple installation instructions. Download the code and edit the lib/Mysql.php file to include your own MySQL code. This is required to pull the information
from the database to create the items that will go into the sale tab. We put anything into the Sale tab that has a lower Special Price than the actual price. We put everything into clearance
where the Special Price is 50% of the regular price. You can change this in the selectClearanceQuery() section of the code. 

## Usage

To use, fill out the lib/Mysql.php file with all of your database credentials. You will also need to fill out the lib/Config.php file with your Sale Category id's, your baseCategoryIds
and your saleCatIds a second time. 

Right now we only have support for MySQL insertion and Rapidflow download CSV file. If you do not feel comfortable having this touch the DB directly, 
then have it export to CSV file for Rapidflow insertion. We are working on an API version so that this will still use the API to change categories in 
the future. 

## Future TODO

* Add in API handling of updated categories for smaller projects or people who are uncomfortable editing MySQL with a script directly. 
* Automatically run index once completed
* Better support for sites w/ unique category configurations
* Allow people to set their own clearance amount in the config section

## Contributing

1. For it!
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

