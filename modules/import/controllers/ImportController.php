<?php

namespace app\modules\import\controllers;

use app\modules\import\models\Import;
use yii\web\Controller;

/**
 * Default controller for the `import` module
 */
class ImportController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $import = new Import();
        $drugs = $import->getDrugs();
//        $drugs = $import->getDrugTest();
        debug($drugs);
        return $this->render('index');
    }
}
