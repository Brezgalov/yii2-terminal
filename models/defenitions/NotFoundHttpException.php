<?php
namespace app\models\definitions;

/**
 * @SWG\Definition()
 *
 * @SWG\Property(property="name", type="string", description="Not Found")
 * @SWG\Property(property="message", type="string", description="Object not found: <id>")
 * @SWG\Property(property="code", type="integer", description="0")
 * @SWG\Property(property="status", type="integer", description="404")
 * @SWG\Property(property="type", type="string", description="yii\\web\\NotFoundHttpException")
 */
class NotFoundHttpException {

}