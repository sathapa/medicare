<?php

class PhBillController extends RController
{
        public $breadcrumbs;
    public $menu;
    public $sumDG;
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='main1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights', // perform access control for CRUD operations
		);
	}


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$model=new PhBill;
        $data = PhOrder::model()->findByPk($id);
        $pid = $data->pid;
        $did = $data->did;

        $dataPO = PhOrder::model()->with('orderPH')->findAllByAttributes(array('pid'=>$pid,'status'=>1));
        //var_dump($dataPO);
        $countPO = count($dataPO);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PhBill']))
		{
			$model->attributes=$_POST['PhBill'];
			if($model->save())
            {
                for ($i=0; $i<$countPO; $i++)
                {
                    //echo $dataPO[$i]->orderPH->SKU."<br>";
                    $qry1 = "UPDATE ph_stock set instore_quantity = instore_quantity-".$dataPO[$i]->quantity." WHERE stock_id= ".$dataPO[$i]->orderPH->stock_id;
                    Yii::app()->db->createCommand($qry1)->execute();
                }

                $qry = "UPDATE ph_order set status=0 WHERE pid=$pid";
                Yii::app()->db->createCommand($qry)->execute();

                Yii::app()->user->setFlash('success','Bill successfully Printed');
                $this->redirect(array('PhOrder/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
            'pid'=>$pid,
            'did'=>$did,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PhBill']))
		{
			$model->attributes=$_POST['PhBill'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->phbid));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $session=new CHttpSession;
            $session->open();		
            $criteria = new CDbCriteria();            

                $model=new PhBill('search');
                $model->unsetAttributes();  // clear any default values

                if(isset($_GET['PhBill']))
		{
                        $model->attributes=$_GET['PhBill'];
			
			
                   	
                       if (!empty($model->phbid)) $criteria->addCondition('phbid = "'.$model->phbid.'"');
                     
                    	
                       if (!empty($model->pid)) $criteria->addCondition('pid = "'.$model->pid.'"');
                     
                    	
                       if (!empty($model->eid)) $criteria->addCondition('eid = "'.$model->eid.'"');
                     
                    	
                       if (!empty($model->discount)) $criteria->addCondition('discount = "'.$model->discount.'"');
                     
                    	
                       if (!empty($model->vat)) $criteria->addCondition('vat = "'.$model->vat.'"');
                     
                    	
                       if (!empty($model->tax)) $criteria->addCondition('tax = "'.$model->tax.'"');
                     
                    	
                       if (!empty($model->total)) $criteria->addCondition('total = "'.$model->total.'"');
                     
                    	
                       if (!empty($model->tender)) $criteria->addCondition('tender = "'.$model->tender.'"');
                     
                    	
                       if (!empty($model->change)) $criteria->addCondition('change = "'.$model->change.'"');
                     
                    	
                       if (!empty($model->datetime)) $criteria->addCondition('datetime = "'.$model->datetime.'"');
                     
                    			
		}
                 $session['PhBill_records']=PhBill::model()->findAll($criteria); 
       

                $this->render('index',array(
			'model'=>$model,
		));

	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PhBill('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PhBill']))
			$model->attributes=$_GET['PhBill'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=PhBill::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ph-bill-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        public function actionGenerateExcel()
	{
            $session=new CHttpSession;
            $session->open();		
            
             if(isset($session['PhBill_records']))
               {
                $model=$session['PhBill_records'];
               }
               else
                 $model = PhBill::model()->findAll();

		
		Yii::app()->request->sendFile(date('YmdHis').'.xls',
			$this->renderPartial('excelReport', array(
				'model'=>$model
			), true)
		);
	}
        public function actionGeneratePdf() 
	{
           $session=new CHttpSession;
           $session->open();
		Yii::import('application.modules.admin.extensions.giiplus.bootstrap.*');
		require_once('tcpdf/tcpdf.php');
		require_once('tcpdf/config/lang/eng.php');

             if(isset($session['PhBill_records']))
               {
                $model=$session['PhBill_records'];
               }
               else
                 $model = PhBill::model()->findAll();



		$html = $this->renderPartial('expenseGridtoReport', array(
			'model'=>$model
		), true);
		
		//die($html);
		
		$pdf = new TCPDF();
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor(Yii::app()->name);
		$pdf->SetTitle('PhBill Report');
		$pdf->SetSubject('PhBill Report');
		//$pdf->SetKeywords('example, text, report');
		$pdf->SetHeaderData('', 0, "Report", '');
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Example Report by ".Yii::app()->name, "");
		$pdf->setHeaderFont(Array('helvetica', '', 8));
		$pdf->setFooterFont(Array('helvetica', '', 6));
		$pdf->SetMargins(15, 18, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);
		$pdf->SetAutoPageBreak(TRUE, 0);
		$pdf->SetFont('dejavusans', '', 7);
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->LastPage();
		$pdf->Output("PhBill_002.pdf", "I");
	}
}
