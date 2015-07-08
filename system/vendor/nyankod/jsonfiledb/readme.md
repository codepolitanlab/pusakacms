# JSON DB

*Forked From philwc/JsonDB with many modifications*

*Handle JSON-Files like a very, very simple DB. Useful for little ajax applications.*

**Example:**

*test.json*
```
[
{"ID": 0, "Name": "Josef Brunzer", "Age": 43},
{"ID": 1, "Name": "Harald Beidlpraka", "Age": 34},
{"ID": 2, "Name": "Heinz Goschnfuada", "Age": 67},
{"ID": 3, "Name": "Gerald Ofnsacka", "Age": 43}
]
```

*test.php*
````
require '../vendor/autoload.php';
$db = new \nyankod\JsonDB('./data/');
$db->setTable('test');
$result = $db->select('Age', 43);
var_dump($result);
````

*result:*

```
array(2) {
  [0]=> array(3) { ["ID"]=> int(0) ["Name"]=> string(13) "Josef Brunzer" ["Age"]=> int(43) }
  [1]=> array(3) { ["ID"]=> int(3) ["Name"]=> string(15) "Gerald Ofnsacka" ["Age"]=> int(43) }
}
```

The default extension is .json. If you want to use a different file extension as ".dat" or whatever, set it in second parameter when create object, `$db = new \nyankod\JsonDB('./data/', '.dat');`

----------


### Method Overview

**JsonDB -> setTable ( "tablename" )** - Set tablename or create table file if not exist. This method have to always be called before doing data transaction.

**JsonDB -> select ( "key", "value" )** - Selects multiple lines which contains the key/value and returns it as array

**JsonDB -> selectAll ()**  - Returns the entire file as array

**JsonDB -> update ( "key", "value", ARRAY )** - Replaces the line which corresponds to the key/value with the array-data

**JsonDB -> updateAll ( ARRAY )** - Replaces the entire file with the array-data

**JsonDB -> insert ( ARRAY )** - Appends a row, returns true on success

**JsonDB -> delete ( "key", "value" )** - Deletes all lines which corresponds to the key/value, returns number of deleted lines

**JsonDB -> deleteAll ()** - Deletes the whole data, returns "true" on success

----------

### Installation

Just download the latest release and extract to your project, or using composer with package name `nyankod/jsonfiledb`.
