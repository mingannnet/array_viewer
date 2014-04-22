array_viewer
============

JSON, Array viewer for PHP

example
============
<code>
&lt;?php
include('array_viewer.php');

$data=array(
  'a'=&gt;'aaaa',
  'b'=&gt;'bbbb',
  'c'=&gt;array(
    'cc'=&gt;array(
      'ccc'=&gt;'ccccccc',
      'ccc2'=&gt;'ccccccc2',
    ),
  ),
);
json_viewer($data);

die('');
?&gt;
</code>
