<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ImportExcelController extends Controller
{
    function index() 
    {
        $data = DB::table('profiles')->orderBy('id', 'DESC')->get();
        return view('import_excel', compact('data'));
    }
    function import(Request $request)
    {
     $this->validate($request, [
      'select_file'  => 'required|mimes:csv,txt'
     ]);

     $path = $request->file('select_file');
     $file = base_path('unidades2.csv');
     $pdo = DB::connection()->getPdo();
     $databasehost = "localhost"; 
     $databasename = "rh_perfil"; 
     $databasetable = "profiles"; 
     $databaseusername="root"; 
     $databasepassword = ""; 
     $fieldseparator = ";"; 
     $lineseparator = "\n";
     $csvfile = "C:\\xampp\\htdocs\\carga\\unidades2.csv";
     
     if(!file_exists($path)) {
         die("File not found. Make sure you specified the correct path.");
     }
     
     
     $affectedRows = DB::connection()->getpdo()->exec("
     LOAD DATA LOCAL INFILE ".$pdo->quote($file)." INTO TABLE `$databasetable`
     FIELDS TERMINATED BY ".$pdo->quote($fieldseparator)."
     LINES TERMINATED BY ".$pdo->quote($lineseparator)."
           IGNORE 1 LINES (empresa, unidade, cargo, previsto)
           SET cargo = UPPER(cargo)");
     
     $str = "Loaded a total of $affectedRows records from this csv file.\n";

     return back()->with("success', 'Excel Data Imported successfully. \n".$str);
    }

    function load($path){
        
    }
}
