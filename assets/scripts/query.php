  <?php
  $m = new MongoClient();
  $db = $m->graffiti;
  $collection = $db->posts;
  $cursor = $collection->find()->sort(array('timeStamp' => -1));
  echo json_encode(iterator_to_array($cursor));

  ?>
