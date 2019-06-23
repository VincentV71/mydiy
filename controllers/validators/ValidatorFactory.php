<?php  
require __DIR__ . '/AromeValidator.php';
require __DIR__ . '/AvisValidator.php';
require __DIR__ . '/BaseValidator.php';
require __DIR__ . '/ParfumerValidator.php';
require __DIR__ . '/PrixValidator.php';
require __DIR__ . '/RecetteValidator.php';
require __DIR__ . '/UserValidator.php';

class ValidatorFactory {

  public static function control (array $donnees, $table) {
    $model_def_all = json_decode(file_get_contents(__DIR__ .'../../../model/json/dataDefinitions.json'), true);
    $index_table;
    for ($i=0; $i < sizeof($model_def_all); $i++){
      if ($model_def_all[$i]['label'] == strtoupper($table))
        $index_table = (int)$i;
    }
    // Définitions du modèle de la classe :
    $model_def_class = $model_def_all[$index_table]['attribut'];

    // Instancie le validator associé à la table :
    $myClassValidator = ($table).'Validator';
    $myValidator = new $myClassValidator($donnees, $model_def_class);
  }

}
?>