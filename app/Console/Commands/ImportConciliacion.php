<?php

namespace Muserpol\Console\Commands;

use Illuminate\Console\Command;
use Muserpol\EconomicComplementApplicant;
use Muserpol\EconomicComplement;
use Muserpol\Affiliate;
use Maatwebsite\Excel\Facades\Excel;
use Muserpol\Helper\Util;
use Carbon\Carbon;
use Log;
use stdClass;


class ImportConciliacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:conc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command of Conciliation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $Progress, $aficount1,$aficount2;
        $password = $this->ask('Enter the password');
        if ($password == ACCESS) {
            $FolderName = $this->ask('Enter the name of the folder you want to import');
            if ($this->confirm('Are you sure to import the folder "' . $FolderName . '" ? [y|N]') && $FolderName) {
                $time_start = microtime(true);
                $this->info("Working...\n");
                $Progress = $this->output->createProgressBar();
                $Progress->setFormat("%current%/%max% [%bar%] %percent:3s%%");
                Excel::batch('public/file_to_import/' . $FolderName . '/', function($rows, $file) 
                {
                    $rows->each(function($result) {
                        global $Progress, $aficount1,$aficount2;
                        ini_set('memory_limit', '-1');
                        ini_set('max_execution_time', '-1');
                        ini_set('max_input_time', '-1');
                        set_time_limit('-1');
                        $ci = $result->ci;
                        if($result->tipo_renta == "VEJEZ")
                        {
                            $app=EconomicComplementApplicant::leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                                        ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                                                        ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                                        ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                                                        ->where('eco_com_types.id','=',1)
                                                        ->where('eco_com_applicants.identity_card','=',rtrim($ci))
                                                        ->where('economic_complements.eco_com_procedure_id','=',6)
                                                        ->select('economic_complements.id')
                                                        ->first();
                            if($app)
                            {
                                $ecom = EconomicComplement::where('id','=',$app->id)->first();
                                //dd($ecom->id);
                                $ecom->eco_com_state_id = 23;
                                //$ecom->state = 'Received';
                                $ecom->save();
                                  $aficount1++;
                                  $this->info($result->ci); 
                            }else
                            {
                                  $aficount1++;
                                  $this->info($result->ci);
                            }
                        
                        }
                        elseif($result->tipo_renta =='VIUDEDAD')
                        {
                             $app=EconomicComplementApplicant::leftJoin('economic_complements','eco_com_applicants.economic_complement_id','=','economic_complements.id')
                                                          ->leftJoin('affiliates','economic_complements.affiliate_id','=','affiliates.id')
                                                          ->leftJoin('eco_com_modalities','economic_complements.eco_com_modality_id','=','eco_com_modalities.id')
                                                          ->leftJoin('eco_com_types','eco_com_modalities.eco_com_type_id','=','eco_com_types.id')
                                                          ->where('eco_com_types.id','=',2)
                                                          ->where('eco_com_applicants.identity_card','=',rtrim($ci))
                                                          ->where('economic_complements.eco_com_procedure_id','=',6)
                                                          ->select('economic_complements.id')
                                                          ->first();
                            //dd($app->id);
                            if($app)
                            {   $ecom = EconomicComplement::where('id','=',$app->id)->first();
                                $ecom->eco_com_state_id = 23;
                                //$ecom->state = 'Received';
                                $ecom->save();
                                  $aficount2++;
                                $this->info($result->ci);
                            }else
                            {
                                  $aficount2++;
                                  $this->info($result->ci);
                            }
                        }

                      
                        $Progress->advance();
                    });
                });
                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $Progress->finish();
                $this->info("\n\nVejez $aficount1 Viudedad $aficount2\n
                
                    
                Execution time $execution_time [minutes].\n");
            }
       }else {
           $this->error('Incorrect password!');
           exit();
       }
    }
}
