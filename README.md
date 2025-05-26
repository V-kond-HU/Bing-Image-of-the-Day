BING: IMAGE OF THE DAY
======================
v0.03


Introduction
------------
'Bing: Image of the Day' is a simple PHP script to get the daily image of Bing for download or use in web-based projects.
Options include to specify
- region of origin  and
- desired resolution

for the image, and also to choose to
- display (in the browser) or
- simply output (in a PHP array)

the information for further use.

Usage
-----
1. Copy index.php (or index.min.php) to a location of your choice and upload it to a local or remote server for use.
   
2. Specify parameters for the script.

   2.1 If using the script embedded (like via 'include'), parameters may be predefined as variables before inserting and executing the script.
       
      Any parameters not predefined will automatically be set to default values on execution.

   2.2 If running the script as a standalone by opening index.php in a web browser, you may define parameters by adding them to the URL
       E.g. ../index.php?out=0&loc=en-US&res=1920x1200
   > For the complete list of parameter options and values refer to Appendix A.

4. Run the script directly by opening index.php (or index.min.php) in your browser or include it for use in a PHP of your choice.



Appendix A: List of script parameters and available values/options
------------------------------------------------------------------
Output options (REQUIRED):
- 0 > Dispay result in browser.
- 1 > Save result in a PHP array.
  > For detailed information about the array refer to Appendix B.

Locales ('loc'), for region-specific images (Optional):
- auto > DEFAULT - used also if locale parameter ('loc') is not user defined. If set, Bing will (try to) determine location based on IP address.
- de_DE (Germany)
- en_AU (Australia)
- en_CA (Canada)
- en_GB (UK)
- en_IN (India)
- en_US (USA)
- fr_CA (Canada)
- fr_FR (France)
- ja_JP (Japan)
- zh_CN (China)

Resolutions ('res') (Optional):
- auto > DEFAULT - used also if resolution parameter ('res') is not user-defined.
- 800x600
- 1024x768
- 1280x720
- 1280x768
- 1366x768
- 1920x1080
- 1920x1200
- 720x1280
- 768x1024
- 768x1280
- 768x1366
- 1080x1920


Appendix B: PHP array output detailes
-------------------------------------
If selected, the script will only save it's results in the backbround into a PHP array as variable '$RESULT'.
Array keys and contents are:

$RESULT = array (
   0 => 'image URL as text string',
   1 => 'image title as text string',
   2 => 'copyright information as text string'
);
