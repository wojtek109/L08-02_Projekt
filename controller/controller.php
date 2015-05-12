<?php
class Controller
{
	public function __construct()
    {
		try
		{
			$model = (isset($_GET['con'])?$_GET['con']:'main');
			$path = 'model/'.$model.'.php';
			$model .= "_Model"; 
			
			if(is_file($path))
			{
				include_once($path);
				$this->model = new $model;
			}
			else
				throw new Exception('Nie mo¿na otworzyæ pliku modelu: '.$path);
		}
        catch(Exception $e)
		{
			$this->throw_error($e);
        }
    }
	
	public function throw_error($e)
	{
		try
		{
			$str = $e->getMessage().'<br><br>
                File: '.$e->getFile().'<br>
                Code line: '.$e->getLine().'<br>
                <pre>Trace: <br>'.$e->getTraceAsString().'</pre>';
				
			$handle = @file_get_contents("view/exception.html");
			if($handle)
			{
				echo(str_replace("{message}", $str, $handle));
				exit;
			}
			else
				throw new Exception('Nie mo¿na otworzyæ widoku b³êdu: view/exception.html<br>Aby wyœwietliæ: <pre>'.$e.'</pre>');
		}
        catch(Exception $e)
		{
			echo($e->getMessage().'<br>
                W pliku: '.$e->getFile().'<br>
                Linia: '.$e->getLine().'<br>
                <pre>Trace: <br>'.$e->getTraceAsString().'</pre>');
			exit;
        }
	}

}
?>