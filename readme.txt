=== UPS Shipping and UPS Access Point™: Official Plugin ===
Requires at least: 4.9.8
Tested up to: 6.1.1
Requires PHP: 7.0
Stable tag: 3.8.0
License: Apache License, version 2.0
License URI: https://www.apache.org/licenses/LICENSE-2.0

Free and official UPS Shipping and UPS Access Point™: Official Plugin developed for WooCommerce which gives access to various UPS shipping services.

== Description ==
IMPORTANT NOTE: This plugin is currently available for merchants in POLAND, FRANCE, UNITED KINGDOM, GERMANY, ITALY, SPAIN, NETHERLANDS, BELGIUM, AUSTRIA, CZECHREPUBLIC, DENMARK, FINLAND, GREECE, HUNGARY, IRELAND, LUXEMBOURG, PORTUGAL, ROMANIA, SLOVENIA, SWEDEN, NORWAY, SWITZERLAND, ICELAND, JERSEY, TURKEY . It will be available for merchants in other countries soon. At this time, please only install this extension if you are in the above mentioned countries.

What this product does for you:
* Available for free.
* Easy to configure in 6 easy steps.
* Gives your customers access to an expansive UPS Access Point network throughout Europe and North America and delivery services to home/office/commercial addresses.
* Adds speed and convenience by allowing merchants to offer a wide range of delivery options in terms of speed (next day, 2 day, etc.) and multiple delivery location options (pick up at a convenient UPS Access Point location or delivery to your customers’ home/office address).
* Improves your online cart conversions. Learn more how you can do this here: https://www.ups.com/assets/resources/media/en_GB/six-steps-to-improve-your-online-cart-conversions.pdf

What are the features of this product:

Front Office:
* Simple & easy map interface for your customers to select UPS Access Point as per their preference.
* User-friendly interface for your customers to switch from Access Point delivery to home delivery.
* Real time UPS shipping rate or flat rates for each available service (as per merchant’s back office settings).
* Supports multiple currencies in the checkout (when WooCommerce Currency Switcher v1.2.1 or above is used).


Back Office:
* Range of options to set up delivery rates that your customers will see (for example: free shipping, real time shipping rates, or flat rates as per basket value thresholds).
* Possibility to open a UPS account directly in the module itself, if you do not have one. 
* Easy PDF label generation.
* Real time tracking information.
* Ability to export open orders so that you can process them in other applications for more complex needs.

Account:
A UPS Account is required to enable UPS shipping.

However, this official UPS module, unlike other shipping modules that enable UPS shipping, does not require you to have a valid UPS Account prior to the module installation!
* If you have a valid UPS Account number: You can directly configure it for this extension by entering your account details (such as account number, invoice amount, number and currency) in extension configuration. No need to involve any UPS Account Manager or Technical Helpline. UPS APIs will do the account verification in the background and, if successful, you can start shipping right away.
* If you do not have a UPS account: You can directly and easily create one in the extension configuration without calling or waiting for any UPS representative. You can manage your invoices directly on the UPS Billing Center on ups.com after the account has been opened in the module.


== Installation ==
Please keep in mind the following before you start installing and configuring the UPS Shipping and UPS Access Point™: Official Plugin for WooCommerce:
1.	Please ensure your webstore is SSL enabled to ensure data-in-transit encryption. Or else, you will be unable to accept UPS Terms & Conditions and proceed further.
2.	After accepting the UPS Terms & Conditions, please ensure that you complete the configuration of the extension within 24 hours to avoid getting any errors during the configuration process. In case you resume the configuration after 24 hours and get errors, please uninstall the extension, clear webstore cache and then re-install the extension.
3.	If you have an existing UPS account number, while registering yourself on the Account page, please use the exact registered pickup address (which might be different from your invoice billing address) associated with this account number. Please note that the format of the postal code or zip code should exactly match the one provided in the registered pickup address. If you have any difficulties understanding which address to use, please contact your local UPS sales representative or call the support phone number provided on the “About” page.
4.	Please make sure Maintenance Mode off.
5.	Following UPS addresses should be whitelisted:
<ul>  
a.https://fa-ecpanalytics-prd.azurewebsites.net
b.https://fa-ecpdashboard-prd.azurewebsites.net
c.https://fa-ecpintegration-prd.azurewebsites.net
d.https://fa-ecptools-prd.azurewebsites.net
e.https://wa-ecpreporting-prd.azurewebsites.net
f.https://onlinetools.ups.com/
</ul>
= Installing and activating the UPS Shipping plugin in the Back Office: =
1.	Download the plugin file
2.	Login to WordPress back office system: Simply go to your browser URL space bar that appears on top, type www.yourwebsitename.com/WP-ADMIN and press, \"Enter\" key.
3.	Once you are in the back office system, go to the plugin page, and click on “Add New” => ”Upload Plugin” => ”Install”.
4.	After installation is completed, click on “Activate Plugin” to complete the activation of the plugin in the back office
= Activating the UPS Shipping plugin in the Front office: =
1.	Click on “WooCommerce” -> ”Setting” -> ”Shipping” -> “Add shipping zone”.
2.	On the “Shipping zone” page, specify the Zone name, zone region and then click on “Add Shipping method”
3.	When you click on \"Add shipping method\", the system will show a popup box with a drop down list. Select \"UPS Shipping\" from the drop down list and click on “Save change”.
= Configuring the UPS Shipping plugin: =
After installing the plugin for the first time, the merchant needs to go through the Configuration section of the plugin. Please see below instructions on how merchants can configure the plugin before putting it into use in the e-commerce site.
1. Select country
<ul>  
a. Select the country from which your packages are shipped.
b. Click ‘Continue’ to go to next screen.
</ul></br>
2. Accepting Terms & Conditions
<ul>
a.	User needs to read through the UPS terms and conditions and the plugin usage agreement, then confirm that the user agreed to them. The user cannot proceed to the next steps if these terms and conditions are not agreed to.
b.	Click ‘Continue’ to go to next screen.
</ul></br>
3.	Account
<ul>
a.	This screen allows merchants to configure their account to use UPS Shipping service. The merchant needs to fill out the required personal information to start using the plugin as instructed in the screen.
b.	After filling out personal information, user selects one of the three options that best describes them and fill in the required information:
  i.	User has a UPS account with an invoice occurred in the last 90 days.
  ii.	User has a UPS account without an invoice occurred in the last 90 days.
  iii.	User does not have a UPS account.
c.	Any incorrect information will result in incorrect configuration. All information has to be entered correctly by the merchant in order to activate the plugin. If the merchant is unsure, they can contact UPS help desk for information prior to activation.
</ul></br>
4.	Shipping Services
<ul>
a.	Various shipping services information, which are available for the particular area would be displayed here. Merchant can select which one is suitable for his e-shoppers.
b.	This shipping service list is automatically loaded from UPS database, depending on the country that the user chose in the first screen.
</ul></br>
5.	Collect on Delivery (COD)
<ul>
a.	UPS Shipping Plugin automatically detects whether user’s WooCommerce website has installed the COD module, and displays that status in the ‘COD Option’ section.
b.	If user wishes to use COD service, he could go to WooCommerce’s market place to install the COD module by WooCommerce and activate that module.
c.	If user wishes to disable COD service in UPS Shipping Plugin, he could deactivate the COD module of WooCommerce. UPS Shipping Plugin will automatically update accordingly.
d.	Click 'Next' to go to the next screen.
</ul></br>
6.	Package Dimensions
<ul>
a.	The user can decide if they want rates calculated and displayed based on:
	I.	Basic – (The number of items in the order determines package size) – This option is best when you sell a single product type and the size of the package for shipping only changes based on the number of products in the customer’s order
			 -	Enter at least one default package size for 1 item in the order
			 -	Enter additional default package sizes based on the number of the items in the order that force a larger average package size
			 -	The package size entered for the highest number of items in the order will apply for all orders equal to or greater than that number of items
			 -	In the screenshot Default Package Configuration - Basic, an order of 1-2 items will rate based on a 12 x 12 x 12 package at 3 lbs, an order of 3-4 items will rate based on a 20 x 20 x 12 package at 6 lbs and every order with 5 or more items will rate based on a 24 x 24 x 24 package at 10 lbs
	II.	Advanced – (Weights and dimensions of products in your customers order, determine the package size) – This option is best when you sell different products ranging in size and weights and the size of package changes based on which and how many products are in the customer’s order
			 -	To use this option, you must enter product weights in the product settings of your shop.
			 -	If you DO NOT enter product dimensions for each product in your product settings and wish to show rates based on order weight only, the select “No” for “Include product dimensions in rating”
			 -	If you DO enter product dimensions for each product in your product settings and want more accurate rates with dimensions considered, the select “Yes” for “Include product dimensions in rating”
			 -	Enter the sizes of the packages you use to fulfill orders.  Note, the plugin will create a custom package size if your customer order is larger than the packages you enter
			 -	Enter at least 1 “Back up” rate and service.  This will ensure the consumer receives a rate if there’s a rating error cause by products missing weights, weights being greater than UPS limits, incorrect units of measure, etc.
			 -	Note, units of weight must be entered in pounds and inches (U.S.) or kilograms and centimeters (Europe). Entering ounces or grams will result in an error and the “Back up” rate showing
			 -	In the screenshot Default Package Configuration - Advanced, the user has entered 3 package sizes for their orders, elected to include product dimensions in rating and will show “Back up” rate of $15.55 for UPS Ground to the consumer if there is a rating error
b.	Click ‘Next’ to go to the next screen.
</ul></br>
7.	Checkout Shipping Rate
<ul>
a.	User can define the delivery rates offered for the e-shoppers here.
b.	The shipping services that user selected in the Shipping Service screen will be automatically loaded to this screen.
c.	User can configure the rates for each shipping service separately. Each shipping service can be configured with two rating options:
  i.	Flat rates: all the orders will be categorized based on order value. If that value is smaller than a defined Order Value Threshold, the corresponding Delivery Rates will be applied. The order with the value higher than the highest Order Value Threshold will enjoy free shipping (Delivery Rate = 0).
  ii.	Real time shipping rates: the delivery rates are calculated based on shipping rates quoted by UPS. User can configure to charge e-shoppers any percentage of that quotation.
d.	Click ‘Save’ to save the delivery rates configuration.
e.	Click ‘Next’ to go to the next screen.
</ul></br>
8.	Complete Configuration
<ul>
a.	This screen shows additional guidance for user to experience UPS’s services.
b.	User can also search for UPS Access Point and print COD and Pickup Registration form.
c.	Click ‘Complete Configuration’ to complete the configuration step.
</ul></br>

== Installation Support: ==
For installation instructions please visit
https://support.ecommerce.help/hc/en-us/sections/4405591774481-Official-Extension-for-WooCommerce

For technical issues please visit
https://ecommerce.help/product/ups-plugins

and open up a support case. Our support team will take care of your issue.

=Telephone Support=
United Kingdom: +44 808 258 0323
Belgium:  +32 78 48 49 16
France: +33 805 11 96 92
Germany: +49 32 221097485
Italy: +39 800 725 920
Netherlands: +31 85 107 0232
Poland: +48 22 103 24 55
Spain: +34 518 90 05 99
Austria: +49 32 221097485
Czechrepublic: +49 32 221097485
Denmark: +49 32 221097485
Finland: +49 32 221097485
Greece: +49 32 221097485
Hungary: +49 32 221097485
Ireland: +49 32 221097485
Luxembourg: +49 32 221097485
Portugal: +49 32 221097485
Romania: +49 32 221097485
Slovenia: +49 32 221097485
Sweden: +49 32 221097485
Norway: +49 32 221097485
Switzerland: +49 32 221097485
Iceland: +49 32 221097485
Jersey: +49 32 221097485
Turkey: +49 32 221097485

== Screenshots ==
1. E-shopper checkout page after configuring UPS Shipping module
2. Merchant back office Account page
3. Merchant back office Shipping Services page
4. Default Package Configuration - Basic
5. Default Package Configuration - Advanced

== Changelog ==

Version 3.8.0:
. Support UPS Express 12:00 service in Germany.

Version 3.7.3:
. French translation issue fixed.

Version 3.7.2:
. Checkout Language issue fixed.
. Support FOX Currency.

Version 3.7.1:
. Minor bug fix..

Version 3.7.0:
. Fixed single country issue at checkout.

Version 3.6.9:
. Minor bug fix..

Version 3.6.8:
. Minor bug fix..

Version 3.6.7:
. Minor bug fix..

Version 3.6.6:
. Total calculation issue fixed.

Version 3.6.5:
. Translation issue fixed.

Version 3.6.4:
. Minor improvements.

Version 3.6.3:
. Minor bug fix.

Version 3.6.2:
. Minor bug fix.

Version 3.6.1:
. Fixed minor bug in timeintransit.

Version 3.6.0:
. Minor improvements.

Version 3.5.1:
. Bug fixed in USD currency.

Version 3.5.0:
. Minor bug fixes in Edit order page shipping services list.

Version 3.4.10:
. Minor bug fixes in checkout page date.

Version 3.4.9:
. Minor bug fixes in shipment manager Exports orders.

Version 3.4.8:
. Minor bug fixes in shipment manager.

Version 3.4.7:
. Minor bug fixes.

Version 3.4.6:
. Minor bug fixes.

Version 3.4.5:
. Minor bug fixes.

Version 3.4.4:
. Fixed php8.1 issues.

Version 3.4.3:
. Minor bug fixes.

Version 3.4.2:
. Minor bug fixes in AP address.

Version 3.4.1:
. Minor bug fixes in order status changes.

Version 3.4.0:
. Minor bug fixes.

Version 3.3.11:
. Minor bug fixes.

Version 3.3.10:
. Minor bug fixes.

Version 3.3.9:
. Minor bug fixes in UI.
 
Version 3.3.8:
. Minor bug fixes.

Version 3.3.7:
. Minor improvements.

Version 3.3.6:
. Minor improvements.

Version 3.3.5:
. Fixed weight and dimension length issue.

Version 3.3.4:
. Fixed tax issues.

Version 3.3.3:
. Added fix for lower weight value and tax.

Version 3.3.2:
. Minor bug fixes.

Version 3.3.1:
. Minor bug fixes.

Version 3.3.0:
. The module supports PHP 8.0.

Version 3.2.2:
. Minor bug fixed on tax calculation and order status.

Version 3.2.1:
. Minor bug fixes.

Version 3.2.0:
. The module supports shipping tax.

Version 3.1.0:
. Updated required 25 EU countries.
. Updated developer key .

Version 3.0.1:
. Bug Fix on packing products of orders with basic packing entry for old orders.
. Added three Europe countries.

Version 3.0.0:
. The module supports all European countries.

Version 2.6.4:
. Minor Bug Fix on Language code while fetching License Text.

Version 2.6.3:
. Fixed minor issues in UPS shipping rates.

Version 2.6.2:
. Fixed minor issues in UPS shipping rates for countries that do not have a ZIP code and minor bug fix in account page.

Version 2.6.1:
. Fixed minor issues in old customer enable AccessPoint as shipping address.

Version 2.6.0:
. Ability for merchants to set up Country based flat shipping rates based on weight and order value.

Version 2.5.1:
. Auto old order import and minor bug fixes in shipment Manager.

Version 2.5.0:
. Added option to generate label for old orders.

Version 2.4.4:
. Improved account registration process.

Version 2.4.3:
. Fixed minor issues in box packing.

Version 2.4.2:
. Fixed packing items into individual instead of box packing, if didn't saved settings after update.

Version 2.4.1:
. Minor bug fixes.

Version 2.4.0:
. Improved packing algorithm.

Version 2.3.1:
. Added option to set AP address as Ship to address.

Version 2.3.0:
. Revamped Account linking and some minor bug fix.

Version 2.2.13:
. Fixed negotiated rates issue in order page.

Version 2.2.12:
. Added AP service check and pre-flight check.

Version 2.2.11:
. Minor bug fix.

Version 2.2.10:
. Calculate Shipping Cost option is introduced in the order details screen
. Reset Username and password option is introduced. 

Version 2.2.9:
. Added new support telephone numbers.

Version 2.2.8:
. Added option to register with UPS username and password.
. Fixed package weight issue with basic packing on label creation.
. Fixed UPS shipping cost update on non-UPS orders.

Version 2.2.7:
. Added shipment creation option on woocommerce order page.

Version 2.2.6:
. Fixed Itemized charge adding issue with negotiated rates.

Version 2.2.5:
. Added the Download log button and fixed a minor bug.

Version 2.2.4:
. Minor bug fixes

Version 2.2.3:
. Bug fix on settings not saved for Package Dimensions Advanced selected if Shipping service => Deliver to consignee address is enabled
. headers already sent error fixed.

Version 2.2.2:
. Bug fix on PHP warnings.
. Calculate after the discount applied option is implemented.
. Bug fix on AccessPoint checkout process.
. Bug fix on Custom prefix table fetch.
. Improvement on AccessPoint checkout process.

Version 2.2.1:
. Minor fix related to UPS version.

Version 2.2.0:
. Price is not updated after changing the Country value.
. Price is not updated after changing the State value.
. Price is not updated while changing the postal code value.
. When 'Ship to a different address?' checkbox is ON, it is not taking the right address for updating price.
. Within 'Ship To' section of Checkout, multiple flows where Price is not updated based on changes in value.
. UI collapses in certain sections within Checkout Screen.
. Use of deprecated javascript and jquery functions that was causing a majority of issues within plugins.
. Map not loading in Access Point selection section.
. When choosing different shipping price from the options available, main shipping cost not getting updated.
. Search the address feature is not working.
. Customer company name not getting printed on shipping label.  Was developed as a new feature improvement.
. Improved CSS for Rate section neatness.
. Tested Upto Latest version of WooCommerce & Wordpress Versions.