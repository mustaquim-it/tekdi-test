<?php

$flat_employees_json = '
  [{
    "id": 8,
    "parent": 4,
    "name": "Food & Lifestyle"
  },
  {
    "id": 2,
    "parent": 1,
    "name": "Mobile Phones"
  },
  {
    "id": 1,
    "parent": 0,
    "name": "Electronics"
  },
  {
    "id": 3,
    "parent": 1,
    "name": "Laptops"
  },
  {
    "id": 5,
    "parent": 4,
    "name": "Fiction"
  },
  {
    "id": 4,
    "parent": 0,
    "name": "Books"
  },
  {
    "id": 6,
    "parent": 4,
    "name": "Non-fiction"
  },
  {
    "id": 7,
    "parent": 1,
    "name": "Storage"
  }]
';


class Tekdi_test
{
    public static function nest(&$records, $recordPropId = 'id', $parentPropId = 'parent', $childWrapper = 'children', $parentId = null)
    {
		$nestedRecords = [];
        foreach ($records as $index => $children) {			        
            if (isset($children[$parentPropId]) && $children[$parentPropId] == $parentId) {
                unset($records[$index]);
                $children[$childWrapper] = self::nest($records, $recordPropId, $parentPropId, $childWrapper, $children[$recordPropId]);
                $nestedRecords[] = $children;
            }
        }

        return array_filter($nestedRecords);
    }
}

$employees = json_decode($flat_employees_json, true);
$managers = Tekdi_test::nest($employees);
echo '<pre>';
print_r(json_encode($managers));