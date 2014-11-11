# JSON DB #
*Forked From Straussn's JSON-Databaseclass*

This serves to clean up the original classes and make composer compatible.

*Handle JSON-Files like a very, very simple DB. Useful for little ajax applications.*

**Example:**

*test.json*

    [
    {"ID": 0, "Name": "Josef Brunzer", "Age": 43},
    {"ID": 1, "Name": "Harald Beidlpraka", "Age": 34},
    {"ID": 2, "Name": "Heinz Goschnfuada", "Age": 67},
    {"ID": 3, "Name": "Gerald Ofnsacka", "Age": 43}
    ]

*test.php*

    require '../vendor/autoload.php';
    $db     = new \philwc\JsonDB('./data/');
    $result = $db->select('test', 'Age', 43);
    var_dump($result);

*result:*

> array(2) {
[0]=> array(3) { ["ID"]=> int(0) ["Name"]=> string(13) "Josef Brunzer" ["Age"]=> int(43) }
[1]=> array(3) { ["ID"]=> int(3) ["Name"]=> string(15) "Gerald Ofnsacka" ["Age"]=> int(43) }
}


If you use a different file extension as ".json", set them via "JsonDB -> setExtension ('.example')"

----------


**Method Overview:**

> **JsonDB -> select ( "table", "key", "value" )** - Selects multible lines which contains the key/value and returns it as array
>
> **JsonDB -> selectAll ( "table" )**  - Returns the entire file as array
>
> **JsonDB -> update ( "table", "key", "value", ARRAY )** - Replaces the line which corresponds to the key/value with the array-data
>
> **JsonDB -> updateAll ( "table", ARRAY )** - Replaces the entire file with the array-data
>
> **JsonDB -> insert ( "table", ARRAY )** - Appends a row, returns true on success
>
> **JsonDB -> delete ( "table", "key", "value" )** - Deletes all lines which corresponds to the key/value, returns number of deleted lines
>
> **JsonDB -> deleteAll ( "table" )** - Deletes the whole data, returns "true" on success


----------
If you use only one json file to store data, you can also use the "JsonTable" Class:

	$db     = new \philwc\JsonTable('./data/test.json');
    $result = $db->select('Age', 43);
    var_dump($result);


In this case, you don't have always to specify the "tablename".