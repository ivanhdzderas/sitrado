<?php

declare(strict_types=0);

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\EmpresaModel;
use App\Models\UsuarioModel;

class Login extends BaseController
{
    protected LoginModel $loginModel;
    protected string $folder = 'archivos/';

        public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->loginModel = model(LoginModel::class);
        $this->folder = 'archivos/';
    }

    protected function page(array $views, array $data = [])
    {
        $html = view('head', $data);
        foreach ($views as $v) {
            $html .= view($v, $data);
        }
        return $this->response->setBody($html);
    }


    public function modifica_solicitud($num=NULL,$num2=null){
        $data=array(
            'nombre'=>$this->request->getPost("nombre"),
            'folio'=>$num,
            'codigo'=>$this->request->getPost("codigo"),
            'tipo'=>$num2
        );
        $this->loginModel->modifica_solicitud($data);
    }
    public function asigna_folio_solicitud(){
        $this->loginModel->asigna_folio_solicitud($_POST);
    }
    public function agregar_alternativa(){
        $this->loginModel->agregar_alternativa($this->request->getPost("alternativa"));
    }
    public function elimina_alternativa(){
        $this->loginModel->elimina_alternativa($this->request->getPost("id"));
    }
    public function elimina_case(){
        $this->loginModel->elimina_case($this->request->getPost("id"));
    }
    public function pdf_business($folio=NULL){
        $data=array(
            'general'=>$this->loginModel->general_business($folio),
            'alternativas'=>$this->loginModel->alternativas($folio),
            'seleccionada'=>$this->loginModel->alter_select($folio),
        );

        echo view("business_case", $data);
    }
    public function guardar_business(){
        $this->loginModel->guardar_business($_POST);

        
    }
    public function tabla_alternativas(){
        $data=array(
            'alternativas'=>$this->loginModel->alternativas($this->request->getPost("folio"))
        );
        echo view("business/alternativas", $data);
    }
    public function prueba(){
      echo view("email/cuerpo1");
    }
    public function nuevo_business(){
        $data=array(
            'usuarios' => $this->loginModel->carga_usuarios(),
        );
        echo view("business/business", $data);
    }
    public function modifica_business_case(){

        $this->loginModel->modifica_business_case($_POST);
    }
    public function modi_case(){
        $folio=$this->request->getPost("id");
         $data=array(
            'usuarios' => $this->loginModel->carga_usuarios(),
            'general'=>$this->loginModel->general_business2($folio),
            'alternativas'=>$this->loginModel->alternativas($folio),
            'seleccionada'=>$this->loginModel->alter_select($folio),
            'folio'=>$folio,
        );
        echo view("business/mod_case", $data);

    }
    public function business(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'business'=>$this->loginModel->lista_business(),
        );
        echo view('business/lista_business', $data);
        
        echo view('footer');
    }
    public function termia_proyecto(){
        $this->loginModel->termia_proyecto($this->request->getPost("id"));
    }
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(site_url('inicio'));
        }

        return view('login_view');
    }
    public function editar_perfil(){
        echo view('head');
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array("datos_usuario"=>$this->loginModel->read_user_information(session()->get('logged_in')['usuario']));
        echo view("usuarios/editar_perfil", $data);
        echo view('footer');
    }
    public function proceso(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
       
        echo view("que_quiero");
        echo view('footer');
        
    }
    public function envia_mensaje(){
        
        $this->loginModel->enviar_mensaje($_POST);

        $data=array(
            'mensajes'=>$this->loginModel->get_mensaje($this->request->getPost("sentto")),
            'id'=>$this->request->getPost("sentto"),
            'contacto'=>$this->loginModel->carga_datos_usuario($this->request->getPost("sentto"))->getResult()
        );

        echo view("mensajes", $data);


    }
    public function solucion_permanente2(){
        $data=array(
            'permanente'=>$this->loginModel->lista_permanente($this->request->getPost("id"))
            );
        echo view('8d/permanente', $data);
    }
    public function carga_trabajo(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        $data=array(
            'usuarios' => $this->loginModel->carga_usuarios(),
        );
        echo view('inicio_cuerpo', $data);
        echo view("carga");
        echo view('footer');
    }
    public function solucion_permanente(){
        $data=array(
            'permanente'=>$this->loginModel->permanente()
            );
        echo view('8d/permanente', $data);
    }
    public function elimina_equipo(){
        $this->loginModel->elimina_equipo($this->request->getPost("equipo"));
    }
    public function agrega_equipo2(){
        $this->loginModel->agrega_equipo2($this->request->getPost("equipo"),$this->request->getPost("id"));
    }
    public function agrega_equipo(){

        $this->loginModel->agrega_equipo($this->request->getPost("equipo"));
    }
    public function lista_equipo_trabajo_2(){
        $data=array(
            'equipo'=>$this->loginModel->lista_equipo($this->request->getPost("id"))
            );
        
        echo view('8d/equipo_trabajo2', $data);
    }
    public function lista_equipo_trabajo(){
        $data=array(
            'equipo'=>$this->loginModel->lista_equipo_sin()
            );
        echo view('8d/equipo_trabajo', $data);
    }
    public function actualiza_perfil(){
        //obtenemos el archivo a subir
        $arreglo=array();
        $file = $_FILES['archivo']['name'];
 
        //comprobamos si existe un directorio para subir el archivo
        //si no es así, lo creamos
        if(!is_dir("files/")) 
            mkdir("files/", 0777);
         
        //comprobamos si el archivo ha subido
        if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"assets/img/faces/".$file))
        {
           sleep(3);//retrasamos la petición 3 segundos
           $data=array(
            'nombre'=>$this->request->getPost("nombre"),
            'usuario'=>$this->request->getPost("usuario"),
            'pass'=>$this->request->getPost("pass"),
            'archivo'=>$file
            );
           $this->loginModel->actualiza_perfil($data);
             $session_data = array(
                            'nombre' => "",
                            'iduser' => "",
                            'img'=>"",
                            'tipo'   => "",
                            'juntas' => "",
                            'usuario'=> "",
                            'plaza'  => "",
                            'nivel'  => "",
                            'reportes'=>"",
                            'departamento'=>"",
                        );





           session()->remove($session_data);
           $result   = $this->loginModel->read_user_information($this->request->getPost("usuario"));
                    if ($result != false) {
                        $session_data = array(
                            'nombre' => $result[0]->nombre,
                            'iduser' => $result[0]->id,
                            'img'=>$result[0]->img,
                            'tipo'   => $result[0]->tipo,
                            'juntas' => $result[0]->juntas,
                            'usuario'=> $result[0]->usuario,
                             'plaza'  => $result[0]->plaza,
                            'nivel'  => $result[0]->nivel,
                            'reportes'=>$result[0]->reportes,
                            'departamento'=>$result[0]->departamento,
                        );


                        $vacac=$this->loginModel->siglas($result[0]->id);
                    
                   
                    foreach ($vacac as $key) {
                       array_push($arreglo,$key->siglas);
                    }

                    $session_data['siglas']=$arreglo;
                        // Pasa el arreglo a la vista
                        session()->set('logged_in', $session_data);
                    }
        }else{
            $data=array(
            'nombre'=>$this->request->getPost("nombre"),
            'usuario'=>$this->request->getPost("usuario"),
            'pass'=>$this->request->getPost("pass"),
            'archivo'=>session()->get('logged_in')['img'],
            );
           $this->loginModel->actualiza_perfil($data);
        }
    }
    public function reporte(){
        //print_r($this->request->getPost("moderador"));
        $moderador="";
        if ($this->request->getPost("moderador")=="on"){
            $moderador="SI";
        }else{
            $moderador="NO";
        }
        



        $tipo=$this->request->getPost("tipo");
        $data=array('fecha'=>$this->request->getPost("fecha"));


       
        if ($this->request->getPost("tipo")==""){
            $data["minutas"]=$this->loginModel->minutas_pendientes($this->request->getPost("fecha"),$this->request->getPost("tipo_global"),$moderador);
        }else{
            foreach ($tipo as $key) {
                if ($key=="analisis"){
                    $data["analisis"]=$this->loginModel->reporte_8d($this->request->getPost("fecha"),$this->request->getPost("tipo_global"));
                }elseif ($key=="proyectos"){
                    $data["proyectos"]=$this->loginModel->reporte_proyectos($this->request->getPost("fecha"),$this->request->getPost("tipo_global"));
                }elseif($key=="minutas"){
                    $data["minutas"]=$this->loginModel->minutas_pendientes($this->request->getPost("fecha"),$this->request->getPost("tipo_global"),$moderador);
                };
            }
        }
       
        if ($this->request->getPost("archivo")=="pdf"){
            echo view('pdf', $data);
        }elseif($this->request->getPost("archivo")=="excel"){
            echo view("excel", $data);
        }
        
    }
    public function reactivar_minuta(){
        $this->loginModel->reactivar_minuta($this->request->getPost("junta"));
    }
    public function reporte_minutas(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'usuarios' => $this->loginModel->carga_usuarios(),
        );
        echo view('juntas/fechas_reporte', $data);
        echo view('footer');
    }
    public function actualiza_subproyecto(){
        $this->loginModel->actualiza_subproyecto($_POST);
    }
    public function modificar_subproyecto(){
        $data = array(
            'usuarios' => $this->loginModel->carga_usuarios(),
            'subproyecto'=>$this->loginModel->subproyecto($this->request->getPost("subproyecto")),
        );
        echo view('proyectos/modifica_subproyecto', $data);
    }
    public function terminar_subproyecto(){
        $this->loginModel->terminar_subproyecto($this->request->getPost("subproyecto"));
    }
    public function agenda(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'agenda'=>$this->loginModel->carga_agenda(session()->get('logged_in')['iduser']),
        );
        echo view('agenda/agenda', $data);
        echo view('footer');
    }
    public function eliminar_evento(){
        $this->loginModel->eliminar_evento($this->request->getPost("id"));
    }
    public function guardar_evento(){
        $this->loginModel->guardar_evento($_POST);
    }
    public function detallado_temas($junta)
    {
         echo view('head');
        
        echo view('menu');
        echo view('herramienta');

        
        $data = array(
            'junta'      => $this->loginModel->lee_junta($junta),
            'det_junta'  => $this->loginModel->det_junta($junta),
            'impartidor' => $this->loginModel->impartidor($junta),
            'id_junta'   => $junta
        );
        echo view('juntas/desglose_junta', $data);


        echo view('finrow');
        echo view("footer2");


        
    }
    public function lista_temas_sin_guardar()
    {
        $data = array(
            'temas' => $this->loginModel->list_sin_guardar(),
        );
        echo view('head');
        echo view('juntas/temas_no', $data);
    }
    public function elimina_tema($num)
    {
        $data = array(
            'numero' => $num,
        );
        $query = $this->loginModel->elimina_tema($data);
        if ($query == true) {
            return redirect()->to(site_url('lista_temas_sin_guardar'));
        }
    }
    public function guarda_junta()
    {

        $data = array(
            'tema'       => $this->request->getPost('tema'),
            'impartidor' => $this->request->getPost('impartidor'),
            'lugar'      => $this->request->getPost('lugar'),
            //'fecha'      => date_format($this->request->getPost('fecha'), 'Y-m-d H:i:s'),
            'fecha'      => $this->request->getPost('fecha'),
            'duracion'   => $this->request->getPost('duracion'),
            'tipo'       => $this->request->getPost('tipo'),
            'id_usuario' => session()->get('logged_in')['iduser']
        );

        $query = $this->loginModel->guardar_junta($_POST);
        if ($query == true) {
            print_r("Guardado con exito");
        }
    }
    public function agrega_tema()
    {
        $data = array(
            'tema' => $this->request->getPost('tema'),
        );
        $query = $this->loginModel->agrega_tema($data);
        if ($query == true) {
            return redirect()->to(site_url('temas'));
        }
    }
    public function temas()
    {
        echo view('head');
        echo view('juntas/ini_temas');
    }
    public function elimina_combo($numero)
    {
        $data = array(
            'integrante' => $numero,
        );
        $query = $this->loginModel->elimina_integrante($data);
        if ($query == true) {
            return redirect()->to(site_url('combocados'));
        }
    }
    public function visor()
    {
        $data = array(
            'archivos' => $this->loginModel->ver_archivo($this->request->getPost('id_tema')),
            'id_subproyecto'=>$this->request->getPost('id_tema')
        );
        echo view('juntas/visor', $data);
    }
    public function agrega_participante()
    {
        $data = array(
            'junta' => $this->request->getPost('junta'),
            'usuarios'=>$this->loginModel->carga_usuarios()
        );
       echo view('juntas/agrega_participante', $data);
    }
    public function lista_a_combocar()
    {
        echo view('head');
        $data = array('usuarios' => $this->loginModel->carga_usuarios());
        echo view('juntas/ad_combocados', $data);
    }
    public function combocados()
    {
        echo view('head');
        $data = array(
            'combo' => $this->loginModel->combocados(),
        );
        echo view('juntas/combocados', $data);
    }
    public function guardar_notas(){
        $this->loginModel->guarda_notas($this->request->getPost("nota"),$this->request->getPost("tema"));
    }
    public function lista_notas2(){
       
        $data=array(
            'lista'=>$this->loginModel->lista_notas2($this->request->getPost("subproyecto")),
            'subproyecto'=>$this->request->getPost("subproyecto"),
            );
        echo view("proyectos/lista_notas", $data);

        
    }
    public function borrar_subproyecto(){
        $this->loginModel->borrar_subproyecto($this->request->getPost("subproyecto"));
    }
    public function lista_notas(){
        $data=array(
            'lista'=>$this->loginModel->lista_notas($this->request->getPost("tema")),
            'tema'=>$this->request->getPost("tema"),
            );
        echo view("juntas/lista_notas", $data);
    }
    public function get_messages(){

        sleep(3);//retrasamos la petición 3 segundos

        $data=array(
            'mensajes'=>$this->loginModel->get_mensaje($this->request->getPost("usuario")),
            'id'=>$this->request->getPost("usuario"),
            'contacto'=>$this->loginModel->carga_datos_usuario($this->request->getPost("usuario"))->getResult()
        );
        echo view("mensajes", $data);
    }
     public function get_messages1(){

        //sleep(20);//retrasamos la petición 3 segundos

        $data=array(
            'mensajes'=>$this->loginModel->get_mensaje($this->request->getPost("usuario")),
            'id'=>$this->request->getPost("usuario"),
            'contacto'=>$this->loginModel->carga_datos_usuario($this->request->getPost("usuario"))->getResult()
        );
        echo view("mensajes", $data);
    }
    public function juntas($valor=NULL)
    {
        echo view('head');
        
        echo view('menu');

        echo view('herramienta');

        $data   = array(
            'junta'        =>$this->loginModel->lee_juntas(),
            'usuarios'     => $this->loginModel->carga_usuarios(),
            'paginacion'   => '',
            
        );
        echo view('juntas/tabla_juntas', $data);
        echo view('finrow');
        echo view("footer2");
    }
    public function reporte_rapido(){
        $data=array(
            'usuarios' => $this->loginModel->carga_usuarios(),
        );
        echo view('reportes/rapido', $data);
    }
    public function pdf_junta($id=NULL){
        $data=array(
            'general'=>$this->loginModel->general_junta($id),
            'detallado'=>$this->loginModel->temas_junta($id),
            'id'=>$id,
        );
        echo view("juntas/pdf", $data);
    }
    public function reactivar(){
        $data=array(
            'subproyecto'=>$this->request->getPost("subproyecto"),
            'nota'=>$this->request->getPost("nota"),
        );
        $this->loginModel->reactivar($data);
    }
    public function lista_empresas(){
        $data=array(
            'empresas'=>$this->loginModel->leer_empresas(),
            'tipo'=>$this->request->getPost('tipo')
            );
        echo view('lista_empresas', $data);
    }
    public function grupo(){
        $data=array(
            'numero'=>$this->request->getPost("empresa")
            );
        echo view("grupos", $data);
    }
    public function subgrupo(){
         $data=array(
            'numero'=>$this->request->getPost("empresa"),
            'data'=>$this->loginModel->leer_grupo($this->request->getPost("empresa")),
            );
        echo view("subgrupo", $data);
    }
    public function archivo_8d(){
    //print_r($this->request->getPost("solucion")."<br />");
    //print_r($this->request->getPost("tipo")."<br />");   
    $data=array(
        'general'=>$this->loginModel->extrae_solucion($this->request->getPost("solucion"),$this->request->getPost("tipo")),
        'tipo'=>$this->request->getPost("tipo"),
        'solucion'=>$this->request->getPost("solucion")
        );
    $variables = array(
            'tipo_solucion' => $this->request->getPost("tipo"),
        );
        session()->set($variables);

    echo view("8d/pendientes", $data);  
    }
    public function ya_pedimento(){
        $this->loginModel->ya_pedimento($this->request->getPost("id"));
    }
    public function pedir_proyecto_business(){
        $this->loginModel->pedir_proyecto_business($this->request->getPost("id"));
    }
    public function ver_nota_reagendar(){
        $result=$this->loginModel->notas_reagendar($this->request->getPost("id"));
        print_r($result[0]->notas);
    }
    public function agregar_agenda(){
    
        $this->loginModel->agregar_agenda($_POST);
    }
    public function alertas()
    {

        if (session()->get('logged_in')["tipo"]=="admin"){
            $data = array(
                'pendientes1' => $this->loginModel->pendientes_juntas(session()->get('logged_in')['iduser']),
                'pendientes2' => $this->loginModel->juntas_proximas(session()->get('logged_in')['iduser']),
                'pendientes3'=>$this->loginModel->pendintes_proyecto(session()->get('logged_in')['iduser']),
                'pendientes4'=>$this->loginModel->pendientes_8d(session()->get('logged_in')["iduser"]),
                'pendientes7'=>$this->loginModel->autorizacion(session()->get('logged_in')["iduser"]),
                'pendientes11'=>$this->loginModel->nuevas_solicitudes(),
            );
        }else{
            $data = array(
                'pendientes1' => $this->loginModel->pendientes_juntas(session()->get('logged_in')['iduser']),
                'pendientes2' => $this->loginModel->juntas_proximas(session()->get('logged_in')['iduser']),
                'pendientes3'=>$this->loginModel->pendintes_proyecto(session()->get('logged_in')['iduser']),
                'pendientes4'=>$this->loginModel->pendientes_8d(session()->get('logged_in')["iduser"]),
                'pendientes7'=>$this->loginModel->autorizacion(session()->get('logged_in')["iduser"]),
                'pendientes11'=>"",
            );
        };



        if (session()->get('logged_in')["plaza"]=="1"){
            $data["pendientes8"]=$this->loginModel->documentos_pendientes();
           
        }
        if (session()->get('logged_in')['iduser']==(session()->get('grade')['proyectos'] ?? null)){
            $data["pendientes9"]=$this->loginModel->por_vencer();
            $data["pendientes5"]=$this->loginModel->archivos(session()->get('logged_in')["iduser"]);
            $data['pendientes6']=$this->loginModel->pedimentos();
            $data['pendientes13']=$this->loginModel->repuesta_reagendar();
        }else{
             $data["pendientes6"]="";
             $data["pendientes5"]="";
        }
        $data["pendientes10"]=$this->loginModel->pendientes_revicion();
        //print_r($this->loginModel->pendientes_8d(session()->get('logged_in')["iduser"]));
        $data["pendientes12"]=$this->loginModel->pendientes_ragendar();
        $data["pendientes14"]=$this->loginModel->pendientes_agenda();
        $data["pendientes15"]=$this->loginModel->proximos_eventos();
        $data["pendientes16"]=$this->loginModel->alerta_raci();
        $data["pendientes17"]=$this->loginModel->alerta_documento();
        $data["pendientes18"]=$this->loginModel->alertas_avisos();
        $this->loginModel->reactiva_juntas();

        echo view('alertas', $data);
    }
    public function terminar_agenda(){
        $this->loginModel->terminar_agenda($this->request->getPost("id"));
    }
    public function solucion_reagendar(){
        $data=array(
            'id'=>$this->request->getPost("id"),
            'solucion'=>$this->request->getPost("solucion"),
        );
        $this->loginModel->solucion_reagendar($data);
    }
    public function alertas2(){
         
        if (session()->get('logged_in')["tipo"]=="admin"){
            $data = array(
                'pendientes1' => $this->loginModel->pendientes_juntas(session()->get('logged_in')['iduser']),
                'pendientes2' => $this->loginModel->juntas_proximas(session()->get('logged_in')['iduser']),
                'pendientes3'=>$this->loginModel->pendintes_proyecto(session()->get('logged_in')['iduser']),
                'pendientes4'=>$this->loginModel->pendientes_8d(session()->get('logged_in')["iduser"]),
                'pendientes7'=>$this->loginModel->autorizacion(session()->get('logged_in')["iduser"]),
                
            );
        }else{
            $data = array(
                'pendientes1' => $this->loginModel->pendientes_juntas(session()->get('logged_in')['iduser']),
                'pendientes2' => $this->loginModel->juntas_proximas(session()->get('logged_in')['iduser']),
                'pendientes3'=>$this->loginModel->pendintes_proyecto(session()->get('logged_in')['iduser']),
                'pendientes4'=>$this->loginModel->pendientes_8d(session()->get('logged_in')["iduser"]),
                'pendientes7'=>$this->loginModel->autorizacion(session()->get('logged_in')["iduser"]),
                
            );
        };



        if (session()->get('logged_in')["plaza"]=="1"){
            $data["pendientes8"]=$this->loginModel->documentos_pendientes();
            $data["pendientes11"]=$this->loginModel->nuevas_solicitudes();
            //'pendientes11'=>$this->loginModel->nuevas_solicitudes(),
           
        }
        if (session()->get('logged_in')['iduser']==(session()->get('grade')['proyectos'] ?? null)){
            $data["pendientes9"]=$this->loginModel->por_vencer();
            $data["pendientes5"]=$this->loginModel->archivos(session()->get('logged_in')["iduser"]);
            $data['pendientes6']=$this->loginModel->pedimentos();
            $data['pendientes13']=$this->loginModel->repuesta_reagendar();
        }else{
             $data["pendientes6"]="";
             $data["pendientes5"]="";

        }
        $data["pendientes10"]=$this->loginModel->pendientes_revicion();
        //print_r($this->loginModel->pendientes_8d(session()->get('logged_in')["iduser"]));
        $data["pendientes12"]=$this->loginModel->pendientes_ragendar();
        $data["pendientes14"]=$this->loginModel->pendientes_agenda();
        $data["pendientes15"]=$this->loginModel->proximos_eventos();
        $data["pendientes16"]=$this->loginModel->alerta_raci();
        $data["pendientes17"]=$this->loginModel->alerta_documento();
        $data["pendientes18"]=$this->loginModel->alertas_avisos();
        echo view("alertas/alertas", $data);
    }
    public function visto(){
        print_r($this->loginModel->visto($_POST["id"]));
    }
    public function  visto2(){
        print_r($this->loginModel->visto2($_POST["id"]));
    }
    public function atender_reagendar(){
        $this->loginModel->atender_reagendar($this->request->getPost("id"));
    }
    public function revisa(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'documentos'=>$this->loginModel->pendientes_revicion()
        );
        echo view("archivos/revisa", $data);
        echo view('footer'); 
        
    }
    public function get_messages_count(){
        sleep(3);
        $result=$this->loginModel->get_messages_count();
       
        foreach ($result->getResult() as $key) {
            $array[]=$key->envia;
        };
        
        //return $array;
        print_r(json_encode($array));

        //print_r($result[0]->id);
        
    }

    public function reorden_chat(){
        //sleep(30);
        $data=array(
            'query'=>$this->loginModel->reorden(),
        );
        echo view("reorden", $data);
    }
    public function punto(){
        echo view('punto');
    }
    public function notas_doc(){
        $result=$this->loginModel->notas_doc($this->request->getPost("id"));
        $recha=$this->loginModel->tracking($this->request->getPost("id"))->getResult();
        foreach ($recha as $key) {
            if ($key->estatus=="R") {
                print_r("[".$key->nombre."][".$key->tipo."]:<br />");
                break;
            }
        }
        print_r($result[0]->mensaje);
    }
    public function modificar_solicitud(){
        $data=array(
            'todo'=>$this->loginModel->general_solicitud($this->request->getPost("id")),

        );
        echo view("archivos/modifica_solicitud", $data);
    }
    public function solicitudes(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'solicitues'=>$this->loginModel->lista_solicitudes(),
        );
        echo view('archivos/tabla_solicitudes', $data);
        echo view('footer'); 
    }
    public function eliminar_solicitud(){
        $this->loginModel->eliminar_solicitud($this->request->getPost("id"));
    }
    public function pdf_solicitud($id=NULL){
        $data=array(
            'general'=>$this->loginModel->general_solicitud($id),
        );
        echo view("archivos/pdf_solicitud", $data);
    }
    public function videochat(){
        
        echo view("video/VidyoConnector");
    }
    public function revisar_doc(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'documentos'=>$this->loginModel->documentos_pendientes()
        );
        echo view('archivos/revisar', $data);
        echo view('footer'); 
    }
    public function solicitud(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        echo view("cambibos");
        echo view('footer');     
    }

    public function documentos_autorizar(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'documentos'=>$this->loginModel->autorizacion(session()->get('logged_in')["iduser"])
        );
        echo view('archivos/autorizar', $data);
        echo view('footer'); 
    }

    /** Catálogo de quién autoriza qué tipo de documento por departamento. */
    public function configurar_aprobadores()
    {
        echo view('head');
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        echo view('archivos/configurar_aprobadores', [
            'aprobadores'   => $this->loginModel->lista_aprobadores(),
            'usuarios'      => $this->loginModel->responsables() ?: [],
            'departamentos' => $this->loginModel->departamentos_catalogo(),
        ]);
        echo view('footer');
    }

    public function form_aprobador()
    {
        $id = (int) ($this->request->getPost('id') ?? 0);
        echo view('archivos/form_aprobador', [
            'item'          => $id > 0 ? $this->loginModel->get_aprobador($id) : null,
            'usuarios'      => $this->loginModel->responsables() ?: [],
            'departamentos' => $this->loginModel->departamentos_catalogo(),
        ]);
    }

    public function guardar_aprobador()
    {
        $ok = $this->loginModel->guardar_aprobador([
            'id_departamento' => $this->request->getPost('id_departamento'),
            'departamento'    => $this->request->getPost('departamento'),
            'usuario'         => $this->request->getPost('usuario'),
            'siglas'          => $this->request->getPost('siglas'),
        ]);
        return $this->response->setJSON(['ok' => (bool) $ok]);
    }

    public function eliminar_aprobador()
    {
        $ok = $this->loginModel->eliminar_aprobador($this->request->getPost('id'));
        return $this->response->setJSON(['ok' => (bool) $ok]);
    }

    public function guarda_estatus_doc2(){
        $this->loginModel->guarda_estatus_doc2($_POST);
    }
    public function guarda_estatus_doc(){
        $this->loginModel->guarda_estatus_doc($_POST);
       
    }
    public function pendientes_juntas()
    {
        $data = array(
            'tema_junta' => $this->loginModel->leer_tema_junta($this->request->getPost('id_tema')),
            'id_tema'    => $this->request->getPost('id_tema'),
        );
        echo view('pendientes', $data);
    }
    public function subir3(){
        $carpetaAdjunta = "archivos_8d/";
        // Contar envían por el plugin

        $archivos = json_encode($_FILES);
       
        //print_r($archivos);
        preg_match('|solucion=(.*)"|sU', $archivos, $id_cliente);
 
        $solucion = str_replace('"', '', $id_cliente[1]);

        $Imagenes            = count(isset($_FILES[$solucion]['name']) ? $_FILES[$solucion]['name'] : 0);
        $infoImagenesSubidas = array();
     
        // El nombre y nombre temporal del archivo que vamos para adjuntar
       // $nombreArchivo  = $id_cliente[1].$_FILES[$id_tema]['file_ext'];
        $nombreArchivo=$id_cliente[1].".".pathinfo($_FILES['solucion='.$id_cliente[1]]['name'], PATHINFO_EXTENSION);
        $nombreTemporal = $_FILES['solucion='.$id_cliente[1]]['tmp_name'];

        $rutaArchivo = $carpetaAdjunta . $nombreArchivo;

        move_uploaded_file($nombreTemporal, $rutaArchivo);
        $rutaArchivo         = base_url() . $rutaArchivo;
        $infoImagenesSubidas = array("caption" => "$nombreArchivo", "height" => "120px", "url" => "borrar.php", "key" => $nombreArchivo);
        $ImagenesSubidas     = "<img  height='120px'  src='$rutaArchivo' class='file-preview-image'>";

        $arr = array("file_id" => 0, "overwriteInitial" => true, "initialPreviewConfig" => $infoImagenesSubidas,
            "initialPreview"       => $ImagenesSubidas);
        echo json_encode($arr);

        $data = array(
            'nombre_archivo' => $nombreArchivo,
            'solucion'        => $id_cliente[1],
        );

        $this->loginModel->carga_archivo_8d($data);
    }
    public function subir()
    {
        $carpetaAdjunta = "archivos_juntas/";
        // Contar envían por el plugin

        $archivos = json_encode($_FILES);
        //print_r($archivos);
        preg_match('|id_tema=(.*)"|sU', $archivos, $id_cliente);
        $id_tema = str_replace('"', '', $id_cliente[0]);

        $Imagenes            = count(isset($_FILES[$id_tema]['name']) ? $_FILES[$id_tema]['name'] : 0);
        $infoImagenesSubidas = array();

        // El nombre y nombre temporal del archivo que vamos para adjuntar
        //$nombreArchivo  = $id_cliente[1].$_FILES[$id_tema]['file_ext'];
        $nombreArchivo=$id_cliente[1].".".pathinfo($_FILES[$id_tema]['name'], PATHINFO_EXTENSION);
        $nombreTemporal = $_FILES[$id_tema]['tmp_name'];

        $rutaArchivo = $carpetaAdjunta . $nombreArchivo;

        move_uploaded_file($nombreTemporal, $rutaArchivo);
        $rutaArchivo         = base_url() . $rutaArchivo;
        $infoImagenesSubidas = array("caption" => "$nombreArchivo", "height" => "120px", "url" => "borrar.php", "key" => $nombreArchivo);
        $ImagenesSubidas     = "<img  height='120px'  src='$rutaArchivo' class='file-preview-image'>";

        $arr = array("file_id" => 0, "overwriteInitial" => true, "initialPreviewConfig" => $infoImagenesSubidas,
            "initialPreview"       => $ImagenesSubidas);
        echo json_encode($arr);

        $data = array(
            'nombre_archivo' => $nombreArchivo,
            'id_tema'        => $id_cliente[1],
        );

        $this->loginModel->carga_archivo_junta($data);

    }
    public function asigna_temas()
    {
        $data = array(
            'usuarios'=> $this->loginModel->participantes_junta($this->request->getPost("junta")),
            'id_junta'      => $this->request->getPost("junta")
        );
        $sessin_data=array(
            'id_minuta'=>$this->request->getPost("junta")
            );
        session()->set('id_minuta',$sessin_data);
        echo view('juntas/juntas', $data);
    }
    public function doc($num, $num2)
    {
        $data = array(
            'grupo'    => $num,
            'subgrupo' => $num2,
        );
        $result = $this->loginModel->carga_archivos3($num2);
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        echo view('iniciorow');
        echo view('archivos/ruta_doc', $data);
        echo view('finrow');
        echo view('iniciorow');
        $data = array(
            'documentos' => $this->loginModel->carga_archivos3($num2),
        );
        echo view('archivos/documento', $data);
        echo view('finrow');
        echo view('footer');
    }
    public function modifica_usuario()
    {
        $data   = array('nombre' => $this->request->getPost('nombre'), 'usuario' => $this->request->getPost('usuario'), 'pass' => $this->request->getPost('pass'), 'tipo' => $this->request->getPost('tipo'), 'id' => $this->request->getPost('id'), 'permisos' => $this->request->getPost('permisos'), 'minutas'=>$this->request->getPost('minutas'));
        $result = $this->loginModel->modifica_usuario($data);
        if ($result == true) {
            return redirect()->to(site_url('usuarios/'));
        }
    }
    public function descargar($name)
    {  
        $nombre=$this->loginModel->nombre_archivo($name)->getResult();
        //$direccion=base_url()."archivos/" . $name;
        //print_r($this->folder . $nombre[0]->nombre);
        $data = file_get_contents($this->folder . $nombre[0]->nombre,FILE_USE_INCLUDE_PATH);
        //print_r($data);
        //exit();
        force_download($nombre[0]->nombre, $data);
    }
    public function nuevo_evento(){
        echo view("nuevo_evento");
    }
    
    public function usuarios($num = null)
    {
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        echo view('iniciorow');
        $data['usuarios'] = $this->loginModel->carga_usuarios();
        $data['data'] = $this->loginModel->carga_empresas();
        $data['documentos']=$this->loginModel->charge_all_document();
        $data['niveles']=$this->loginModel->niveles();
        echo view('usuarios/inicio', $data);
       
        echo view('finrow');
      
        echo view('footer');
    }
    public function elimina_grupo($num, $num2)
    {
        $result    = $this->loginModel->elimina_gropo($num);
        $variables = array(
            'mensaje_empresas' => "Grupo eliminado con exito",
        );
        session()->set($variables);
        return redirect()->to(site_url('empresas/' . $num2));
    }
    public function elimina_subgrupo($num, $num2)
    {
        $result    = $this->loginModel->elimina_subgrupo($num);
        $variables = array(
            'mensaje_empresas' => "Submenu eliminado con exito",
        );
        session()->set($variables);
        return redirect()->to(site_url('empresas/' . $num2));
    }
    public function elimina_menu()
    {
        $result = $this->loginModel->elimina_menu($this->request->getPost("menu"));
      
    }
    public function agrega_empresa()
    {
        $config['upload_path']   = 'logos/';
        $config['allowed_types'] = 'zip|rar|pdf|docx|txt|jpg|jpeg|png';
        $config['remove_spaces'] = true;
        $config['max_size']      = '0';
        // library
       
        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            if ($error['error']=="<p>You did not select a file to upload.</p>"){
                $data = array(
                'nombre'     => $this->request->getPost('nombre_empresa'),
                'calle'      => $this->request->getPost('calle'),
                'numero_ext' => $this->request->getPost('numero_ext'),
                'numero_int' => $this->request->getPost('numero_int'),
                'colonia'    => $this->request->getPost('colonia'),
                'ciudad'     => $this->request->getPost('ciudad'),
                'estado'     => $this->request->getPost('estado'),
                'cp'         => $this->request->getPost('cp'),
                'rfc'        => $this->request->getPost('rfc'),
                'apoderado'  => $this->request->getPost('apoderado'),
                'logo'       => "",
            );
            $result = $this->loginModel->crea_empresa($data);
            if ($result != false) {
                $variables = array(
                    'mensaje_empresas' => "Empresa guardada con exito",
                    'tipo'             => 'ok',
                );
                session()->set($variables);
                return redirect()->to(site_url('empresas'));
            } else {
                $variables = array(
                    'mensaje_empresas' => "Empresa duplicada",
                    'tipo'             => 'error',
                );
                session()->set($variables);
                return redirect()->to(site_url('empresas'));
            }
            }
            print_r($error);
            exit();
        } else {
            $data = array('upload_data' => $this->upload->data());
            $data = array(
                'nombre'     => $this->request->getPost('nombre_empresa'),
                'calle'      => $this->request->getPost('calle'),
                'numero_ext' => $this->request->getPost('numero_ext'),
                'numero_int' => $this->request->getPost('numero_int'),
                'colonia'    => $this->request->getPost('colonia'),
                'ciudad'     => $this->request->getPost('ciudad'),
                'estado'     => $this->request->getPost('estado'),
                'cp'         => $this->request->getPost('cp'),
                'rfc'        => $this->request->getPost('rfc'),
                'apoderado'  => $this->request->getPost('apoderado'),
                'logo'       => $this->upload->data()['orig_name'],
            );
            $result = $this->loginModel->crea_empresa($data);
            if ($result != false) {
                $variables = array(
                    'mensaje_empresas' => "Empresa guardada con exito",
                    'tipo'             => 'ok',
                );
                session()->set($variables);
                return redirect()->to(site_url('empresas'));
            } else {
                $variables = array(
                    'mensaje_empresas' => "Empresa duplicada",
                    'tipo'             => 'error',
                );
                session()->set($variables);
                return redirect()->to(site_url('empresas'));
            }
        }
    }
    public function agrega_grupo()
    {
        $data = array('nombre' => $this->request->getPost('nombre_grupo'),
            'empresa'              => $this->request->getPost('empresa_grupo'),
        );
        $result = $this->loginModel->crea_grupo($data);
       
    }
    public function empresas($num = null)
    {
        $data = array(
            'data'    => $this->loginModel->leer_empresas(),
            'mensaje' => '',
        );
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        if ($num != null) {
            $datos['nombre'] = $this->loginModel->nombre_empresa($num);
            echo view('iniciorow');
            echo view('nombre_empresa', $datos);
            echo view('finrow');
        }
        echo view('iniciorow');
        echo view('home_view', $data);
        echo view('finrow');
    }
    public function guarda_analisis2(){
        $this->loginModel->guarda_analisis2($_POST);
        //return redirect()->to(site_url('8d'));
    }
    public function agrega_sala(){
        echo view("configuracion/nueva_sala");
    }
    public function elimina_sala(){
        $this->loginModel->elimina_sala($this->request->getPost("id"));
    }
    public function guardar_sala(){

        $this->loginModel->agregar_sala($_POST);
    }
    public function guardar_sala_mod($num=NULL){
        $data=array(
            'nombre'=>$this->request->getPost("nombre"),
            'direccion'=>$this->request->getPost("direccion"),
            'numero'=>$num
        );
        $this->loginModel->guarda_sala_mod($data);
    }
    public function mod_sala(){
        $data=array(
            'sala'=>$this->loginModel->sala($this->request->getPost('id')),
        );
        echo view("configuracion/mod_sala", $data);
    }
    public function salas(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'salas'=>$this->loginModel->salas(),
        );
        echo view('configuracion', $data);
        echo view('footer');
    }
    public function guarda_analisis(){
        $this->loginModel->guarda_analisis($_POST);
        return redirect()->to(site_url('8d'));

    }
    public function pdf_8d($num){
        $data=array(
            'general'=>$this->loginModel->general_8d($num),
            'equipo'=>$this->loginModel->lista_equipo($num),
            'temporales'=>$this->loginModel->lista_temporales($num),
            'permanente'=>$this->loginModel->lista_permanente($num),
            'preventivo'=>$this->loginModel->preventivos($num)
            );
        echo view("8d/pdf", $data);
    }
    public function elimina_temporal(){
        $this->loginModel->elimina_temporal($this->request->getPost("id"));
    }
    public function elimina_preventivo(){
        $this->loginModel->elimina_preventivo($this->request->getPost("id"));
    }
    public function elimina_permanente(){
        $this->loginModel->elimina_permanente($this->request->getPost("id"));
    }
    public function agrega_preventivo2(){
        $this->loginModel->agrega_preventivo2($_POST);
    }
    public function agrega_preventivo(){
        $this->loginModel->agrega_preventivo($_POST);
    }
     public function agrega_permanente2(){

        $this->loginModel->agrega_permanente2($_POST);
    }
    public function agrega_permanente(){
        $this->loginModel->agrega_permanente($_POST);
    }
    public function agrega_temporal2(){
        $this->loginModel->agrega_temporal2($_POST);
    }
    public function agrega_temporal(){
        $this->loginModel->agrega_temporal2($_POST);
    }
    public function temporales2(){
        $data=array(
            'temporales'=>$this->loginModel->temporales($this->request->getPost("id"))
            );
        echo view("8d/temporales", $data);   
    }
    public function temporales(){
        $data=array(
            'temporales'=>$this->loginModel->temporales('0')
            );
        echo view("8d/temporales", $data);
    }
    public function convertir_proyecto(){
        $query=$this->loginModel->buscar_proryecto($this->request->getPost("id"));
        if ($query->num_rows()==0){
             $this->loginModel->convertir_proyecto($this->request->getPost("id"));  
             //return redirect()->to('proyectos');   
        }else{
            
            return false;
        }
       
    }
    public function elimina_analisis(){
        $this->loginModel->elmina_analisis($this->request->getPost("id"));
    }
    public function nuevo_analisis(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'personal'=>$this->loginModel->carga_usuarios()
            );
        echo view('8d/nuevo_analisis', $data);
        echo view('footer'); 
    }
    public function desglose_8d($num=NULL){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'general'=>$this->loginModel->general_8d($num),
            'equipo'=>$this->loginModel->lista_equipo($num),
            'temporales'=>$this->loginModel->lista_temporales($num),
            'permanentes'=>$this->loginModel->lista_permanente($num),
            'preventivos'=>$this->loginModel->preventivos($num),
            'personal'=>$this->loginModel->carga_usuarios(),
            'id_8d'=>$num,
            );
        echo view("8d/desglose", $data);
        echo view('footer');
    }
    public function analisis2(){
        echo view('head');
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'analisis'=>$this->loginModel->empresa_8d(session()->get('logged_in')['iduser'])
            );
        echo view('8d/tabla_8d2', $data);
        echo view('footer');
    }
    public function limpiar_8d(){
        $tipo=$this->request->getPost("tipo");
        switch ($tipo) {
            case 't':
                $this->loginModel->limpiar_8d($this->request->getPost("folio"),'temporal');
                break;
            case 'p':
                $this->loginModel->limpiar_8d($this->request->getPost("folio"),'permanente');
                break;
            case 'e':
                $this->loginModel->limpiar_8d($this->request->getPost("folio"),'preventivo');
                break;
        }
    }
    public function terminar_8d(){
        $tipo=$this->request->getPost("tipo");
        switch ($tipo) {
            case 't':
                $this->loginModel->terminar_temporal($this->request->getPost("folio"));
                break;
            case 'p':
                $this->loginModel->terminar_permanente($this->request->getPost("folio"));
                break;
            case 'e':
                $this->loginModel->terminar_preventivo($this->request->getPost("folio"));
                break;
        }
    }
    public function detallado_8d($num){
        echo view('head');
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'general'=>$this->loginModel->general_8d($num),
            'equipo'=>$this->loginModel->lista_equipo($num),
            'temporales'=>$this->loginModel->lista_temporales($num),
            'permanente'=>$this->loginModel->lista_permanente($num),
            'preventivo'=>$this->loginModel->preventivos($num)
            );
        echo view("8d/detallado", $data);
        echo view('footer');
    }
    public function analisis(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'analisis'=>$this->loginModel->carga_8d()
            );
        echo view('8d/tabla_8d', $data);
        echo view('footer');

    }

    public function solucion_preventivos2(){
        $data=array(
            'preventivo'=>$this->loginModel->preventivos($this->request->getPost("id"))
            );
        echo view('8d/preventivo', $data);
    }
    public function solucion_preventivos(){
        $data=array(
            'preventivo'=>$this->loginModel->lista_preventivos()
            );
        echo view('8d/preventivo', $data);
    }
    public function agrega_submenu()
    {
        $data = array(
            'nombre' => $this->request->getPost('nombre_submenu'),
            'menu'   => $this->request->getPost('menu'),
        );
        $result = $this->loginModel->crea_submenu($data);
        
    }
    public function combo_menus(){
        $data=array("menu"=>$this->loginModel->menu_de_empresa($this->request->getPost("empresa")));
        echo view("archivos/combo_menu", $data);
    }
    public function permisos_grupales(){
        $data=array("permisos"=>$this->loginModel->leer_subrupos($this->request->getPost("empresa")));
        echo view("archivos/permisos", $data);
    }
    public function combo_submenu(){
        $data=array("submenus"=>$this->loginModel->carga_submenu($this->request->getPost("menu")));
        echo view("archivos/combo_submenu", $data);
    }
    public function menus($num = null)
    {
         echo view('head');
         
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        echo view('iniciorow');
        
        echo view('finrow');
        echo view('iniciorow');
       $data = array(
            'data'    => $this->loginModel->extrae_todo(),
            'mensaje' => '',
        );
        echo view("menus/tabla_menus", $data);
        echo view('finrow');
        echo view("footer2");


        
        
    }
    public function nuevo_submenu(){
        $data=array(
            'empresas'=>$this->loginModel->carga_empresas()
            );
        echo view('menus/nuevo_submenu', $data);
    }
    public function nuevo_menu(){
        $data=array(
            'empresas'=>$this->loginModel->carga_empresas()
            );
        echo view('menus/nuevo_menu', $data);
    }
    public function pdf_mejora($num=NULL){
        $data=array(
            "mejora"=>$this->loginModel->general_mejora($num)
        );
        echo view("mejora/pdf", $data);
    }
    public function eliminar_eliminar(){
        unlink('papelera/documentos/'.$this->request->getPost("documento"));

    }
    public function elimina_mejora(){
        $this->loginModel->elimina_mejora($this->request->getPost("id"));
    }
    public function guardar_mejora(){
        $this->loginModel->guardar_mejora($_POST);
    }
    public function guardar_mod_mejora($num=NULL){
        $this->loginModel->guardar_mod_mejora($_POST,$num);
    }
    public function modifica_mejora(){
        $data=array(
            'usuarios' => $this->loginModel->carga_usuarios(),
            "mejora"=>$this->loginModel->general_mejora($this->request->getPost("id")),
        );
        echo view("mejora/modifica", $data);
    }
    public function nueva_propuesta(){
        $data=array(
            'usuarios' => $this->loginModel->carga_usuarios(),
        );
        echo view("mejora/nueva_mejora", $data);
    }
    public function mejora(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array(
            'mejoras'=>$this->loginModel->lista_mejora(),
        );
        echo view('mejora/tabla_mejora', $data);
        echo view('footer');
    }
    public function videos(){
        $data = array('nombre' => $this->loginModel->nombre_archivo($this->request->getPost("id")));
        echo view("videos", $data);
    }
    public function leer($id)
    {

        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data = array('nombre' => $this->loginModel->nombre_archivo($id));
        echo view('archivos/leer', $data);
        echo view('footer');
    }
    public function nuevo_documento(){
        $data=array('empresas'=>$this->loginModel->carga_empresas(),
            'departamento'=>$this->loginModel->departamento(),
            'responsables'=>$this->loginModel->responsables(),
    );
        echo view("archivos/nuevo_documento", $data);
    }
    public function ver_evento(){
        $query=$this->loginModel->ver_evento($this->request->getPost("id"));
        print_r($query[0]->descripcion);
    }
    public function eventos(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
       
            $data = array(
                'eventos' => $this->loginModel->eventos()->getResult(),
            );
            echo view('eventos', $data);
            echo view('finrow');
       
        echo view('footer');
    }
    public function documento($tipo)
    {
        echo view('head');
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        echo view('archivos/documento', [
            'documentos' => $this->loginModel->documentosPorTipo((string) $tipo),
            'tipo'       => $tipo,
        ]);
        echo view('finrow');
        echo view('footer');
    }
    public function elimina_submenu()
    {
        $result = $this->loginModel->elimina_submenu($this->request->getPost("submenu"));
        
    }
    public function agrega_menu()
    {
        $data = array('nombre' => $this->request->getPost('nombre_menu'),
            'empresa'              => $this->request->getPost('empresa'),
        );
        $result = $this->loginModel->crea_menu($data);
        
    }
    public function do_upload()
    {
        $config['upload_path']   = $this->folder;
        //$config['allowed_types'] = 'zip|rar|pdf|docx|txt|ppt|doc|pptx|xlsx|xls|webm|mp4';
        $config['allowed_types'] ='*';
        $config['remove_spaces'] = true;
        $config['max_size']      = '0';
        
        // library
        if (!$this->upload->do_upload()) {
           
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
            exit();
        } else {
            $data = array('upload_data' => $this->upload->data());
            //print_r($this->upload->data()['file_ext']);

            rename("archivos/". $this->upload->data()['orig_name'],"archivos/".$this->request->getPost("re_nombre").$this->upload->data()['file_ext']);
            $data = array(
                //'nombre'   => $this->upload->data()['orig_name'],
                'nombre'=>$this->request->getPost("re_nombre").$this->upload->data()['file_ext'],
                'descarga' => $this->request->getPost('descarga'),
                'menu'     => $this->request->getPost('menu'),
                'submenu'  => $this->request->getPost('submenu'),
                'permisos' => $this->request->getPost('permisos'),
                'tipo'     => $this->request->getPost('tipo'),
                'todos'     =>$this->request->getPost('todos'),
                'departamento'=>$this->request->getPost("departamento"),
                'folio'=>$this->request->getPost("folio_doc"),
                'vali'=>$this->request->getPost("vali"),
                'revision'=>$this->request->getPost("revision"),
            );
            $this->loginModel->crea_archivo($data);
            $variables = array(
                'mensaje_documento' => "Documento guardado con exito",
            );
            session()->set($variables);
            return redirect()->to(site_url('documentos'));
        }
    }
    public function busca_carga_trabajo(){
        $dato=array(
            'usuario'=>$this->request->getPost('usuario'),
            'f_inicio'=>$this->request->getPost('f_inicio'),
            'f_fin'=>$this->request->getPost('f_fin'),
        );
        $data=array(
            'usuario'=>$this->loginModel->carga_datos_usuario($this->request->getPost('usuario')),
            'responsable'=>$this->loginModel->cargas_raci_responsable($dato),
            'aprobado'=>$this->loginModel->cargas_raci_aprobado($dato),
            'consultado'=>$this->loginModel->cargas_raci_consultado($dato),
            'informado'=>$this->loginModel->cargas_raci_informado($dato),
            'moderador'=>$this->loginModel->cargas_moderador($dato),
            'actividades'=>$this->loginModel->cargas_actividades_juntas($dato),
            'temporal'=>$this->loginModel->carga_8d_temporal($dato),
            'permanente'=>$this->loginModel->carga_8d_permanente($dato),
            'preventivo'=>$this->loginModel->carga_8d_preventivo($dato),
        );
       
        echo view('reportes/carga', $data);
        
    }
    public function reporte_general($tipo){
        $data=array(
            'usuarios' => $this->loginModel->carga_usuarios(),
        );
        if ($tipo=="pdf"){
            echo view("reportes/carga_general", $data);
        }else{
             echo view("reportes/excel", $data);
             //sleep(3);//retrasamos la petición 3 segundos
             //$file=base_url()."Reporte_carga.xlsx";
             $data = file_get_contents("Reporte_carga.xlsx",FILE_USE_INCLUDE_PATH);
            //print_r($data);
            //exit();
            force_download("Reporte_carga.xlsx", $data);

             //header('Location: http://docs.google.com/viewer?url='.$file);
        }
    }
    public function pastel1(){
       
        echo view('reportes/pastel');
    }
    public function resultado_busqueda(){
        $data=array('encontrado'=>$this->loginModel->busca_folio($this->request->getPost("folio")));
        echo view("archivos/resultado", $data);
    }
    public function bus_folio(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        echo view("archivos/busqueda_documentos");
        echo view('footer');
    }
    public function documentos($num = null, $num2 = "", $num3 = null)
    {
        echo view('head');
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        echo view('iniciorow');
        $data = array(
            'doc' => $this->loginModel->carga_documentos(),
        );
        echo view("tabla_documentos", $data);
        echo view('finrow');
        echo view("footer2");
    }
    public function tracking(){
        $data=array(
            'track'=>$this->loginModel->tracking($this->request->getPost("id")),
            'id'=>$this->request->getPost("id"),
        );
        echo view("archivos/tracking", $data);
    }
    public function guardar_solicitud_documento($tipo=NULL){
        if ($tipo=="creacion"){
            //print_r($_POST);
            $data=array(
                'tipo'=>"N",
                'nombre_doc'=>$this->request->getPost("nombre"),
                'especificar'=>$this->request->getPost("descripcion"),
                'tipo_doc'=>$tipo,
            );
            $this->loginModel->guardar_solicitud($data);
        }else{
            $data=array(
                'tipo'=>$this->request->getPost("tipo"),
                'nombre_doc'=>$this->request->getPost("nombre"),
                'especificar'=>$this->request->getPost("descripcion"),
                'tipo_doc'=>$tipo,
            );
            $this->loginModel->guardar_solicitud($data);
        }
    }
    public function otro(){
        $data=array(
            'archivos'=>$this->loginModel->carga_documentos_nivel(),
        );
        echo view("archivos/otro", $data);
    }
    public function creacion(){
        echo view("archivos/creacion");
    }
    public function activa_doc(){
        $this->loginModel->activa_doc($this->request->getPost("documento"));
    }
    public function user_login_process()
    {
        $arreglo  = [];
        $username = (string) $this->request->getPost('username');
        $password = (string) $this->request->getPost('password');

        $result = $this->loginModel->login($username, $password);
        if ($result == true) {
            $result = $this->loginModel->read_user_information($username);

            if ($result != false) {
                $session_data = [
                    'nombre'       => $result[0]->nombre,
                    'iduser'       => $result[0]->id,
                    'img'          => $result[0]->img,
                    'tipo'         => $result[0]->tipo,
                    'juntas'       => $result[0]->juntas,
                    'usuario'      => $result[0]->usuario,
                    'plaza'        => $result[0]->plaza,
                    'nivel'        => $result[0]->nivel,
                    'reportes'     => $result[0]->reportes,
                    'departamento' => $result[0]->departamento,
                    'puesto'       => $result[0]->puesto,
                    'correo'       => $result[0]->correo ?? '',
                ];

                $this->loginModel->entrada($result[0]->id);
                $vacac = $this->loginModel->siglas($result[0]->id) ?: [];

                foreach ($vacac as $key) {
                    $arreglo[] = $key->siglas;
                }
                $session_data['siglas'] = $arreglo;

                session()->set('logged_in', $session_data);

                $config = $this->loginModel->configuracion();
                if ($config != false) {
                    session()->set('grade', ['proyectos' => $config[0]->encargada_proyectos]);
                }

                return redirect()->to(site_url('inicio'));
            }
        }

        return view('login_view', ['error_message' => 'Usuario o Password No válidos.']);
    }
    public function inicio (){
        echo view('head');

        echo view('menu');
        echo view('herramienta');
        echo view('asistente_inicio');


        echo view('finrow');
        echo view("footer2");
    }
    public function empresa($empresa)
    {
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        echo view('footer');
    }
    public function agrega_subgrupo()
    {
        $data = array('nombre' => $this->request->getPost('nombre_subgrupo'),
            'grupo'                => $this->request->getPost('grupo'),
            'empresa'              => $this->request->getPost('empresa_grupo'),
        );
        $result = $this->loginModel->crea_subgrupo($data);
        
    }
    public function logout()
    {
        $logged = session()->get('logged_in');
        if (! empty($logged['iduser'])) {
            $this->loginModel->salir($logged['iduser']);
        }
        session()->remove('logged_in');
        session()->remove('grade');
        return redirect()->to(site_url('login'))->with('success', 'La sesión finalizó correctamente.');
    }
    public function juntas_venir()
    {
        $data = array(
            'datos_junta' => $this->loginModel->lee_junta($this->request->getPost('id_junta')),
        );
        echo view('alerta_junta', $data);

    }
    public function eliminar_proyecto(){
        $this->loginModel->eliminar_proyecto($this->request->getPost("proyecto"));
    }
    public function raci($num){
        $data=array(
            'tareas'=>$this->loginModel->raci($num),
            'partes'=>$this->loginModel->detalles_proyecto($num)->getResult(),

            );
        echo view('proyectos/raci', $data);
    }
    public function proyectos2(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        $data = array(
            'lista_proyectos' => $this->loginModel->lista_proyectos2(session()->get('logged_in')['iduser']),
        );
        echo view('proyectos/tabla_proyectos2', $data);   
    }
    public function nuevo_aviso(){
        echo view("alertas/nuevo_aviso");
    }
    public function elimina_aviso(){

        print_r($this->loginModel->elimina_aviso($_POST["id"]));
    }
    public function modifica_aviso(){
        print_r($this->loginModel->modifica_aviso($_POST));
    }
    public function guarda_aviso(){

        print_r($this->loginModel->guarda_aviso($_POST));
    }
    public function edita_aviso(){
        $data["general"]=$this->loginModel->busca_aviso($_POST["id"]);
        $data["id"]=$_POST["id"];
        echo view("alertas/edita_aviso", $data);
    }
    public function avisos(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        echo view('iniciorow');
        $data=array(
            'lista'=>$this->loginModel->lista_avisos(),
        );
        echo view('alertas/tabla_avisos', $data);
        echo view('finrow');
        echo view("footer2");
    }
    public function proyectos()
    {
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
         echo view('inicio_cuerpo');
        echo view('iniciorow');
        $data = array(
            'lista_proyectos' => $this->loginModel->lista_proyectos(),
        );
        echo view('proyectos/tabla_proyectos', $data);
        echo view('finrow');
        echo view("footer2");
    }
    public function modifica_proyecto(){
        $data = array(
            'usuarios' => $this->loginModel->carga_usuarios(),
            'proyecto'=>$this->loginModel->nombre_proyecto($this->request->getPost("proyecto"))
        );
        echo view("proyectos/modifica_proyecto", $data);
    }
    public function guardar_notas2(){

        $this->loginModel->guarda_notas2($_POST);
    }
    public function nuevo_proyecto()
    {
        $data = array(
            'usuarios' => $this->loginModel->carga_usuarios(),
        );
        echo view('proyectos/nuevo_proyectos', $data);
    }
    public function guarda_mod_proyecto(){
        $data = $_POST;

        $this->loginModel->guarda__mod_proyecto($data);
       
    }
    public function guarda_proyecto()
    {
        $data = $_POST;
        $this->loginModel->guarda_proyecto($data);
        print_r("Guardado exitosamente");
    }
    public function signa_tareas()
    {
        $data = array(
            'proyectos' => $this->loginModel->carga_proyectos_sin_tarea(),
            'usuarios'  => $this->loginModel->carga_usuarios(),
            
        );
        if ($this->request->getPost('proyecto')!=NULL){
            $data['id_proyect']=$this->request->getPost('proyecto');
        }
        echo view('proyectos/asigna_tareas', $data);
    }
    public function elimina_informador(){
        $this->loginModel->elimina_informador($this->request->getPost("id"));
    }
    public function elimina_consultado(){
        $this->loginModel->elimina_consultado($this->request->getPost("id"));
    }
    public function lista_informado(){
        $data=array(
            'informados'=>$this->loginModel->lista_informado($this->request->getPost("id_tarea"))
            );
        echo view("proyectos/lista_informados", $data);
    }
    public function lista_consultado(){
        $data=array(
            'consultado'=>$this->loginModel->lista_consultado($this->request->getPost("id_tarea"))
            );
        echo view("proyectos/lista_consultado", $data);
    }
    public function tareas_sin_asignar()
    {
        sleep(3);
        $data=array(
            'sin_asignar'=>$this->loginModel->proyectos_sin_asignar($this->request->getPost("proyecto"))->getResult()
            );
        echo view('proyectos/tabla_sin_asignar', $data);
    }
    public function agrega_informado(){
        $this->loginModel->agrega_informado($_POST);
    }
    public function agrega_consultor(){
        $this->loginModel->agrega_consultor($_POST);
    }
    public function responsables(){
         $data = array(
            'usuarios'  => $this->loginModel->carga_usuarios(),
            'folio'=>$this->request->getPost("id_tarea"),
        );
        echo view("proyectos/responsables", $data);
    }
    public function asigna_tareas()
    {
        $data = $_POST;

        $this->loginModel->guarda_tarea($data);
    }
    public function elimina_tarea()
    {
        $data=$this->request->getPost("id_tarea");
        $this->loginModel->elimina_tarea($data);
    }
    public function guarda_tareas()
    {
        $query=$this->loginModel->guardar_tarea($_POST);
        if ($query != false) {
            print_r("Tareas asignadas exitosamente");
        }else{
            print_r("Ocurrio un error en el servidor");
        };
    }
    public function fechas_proyecto()
    {   
        $data['fechas']=$this->loginModel->fechas_proyecto($this->request->getPost('proyecto'));
        echo view('proyectos/fechas_proyecto', $data);
    }
    public function gantt($proyecto)
    {
        echo view('head');
        echo view('inicio_cuerpo');
        $data=array(
            'nombre_proyecto'=>$this->loginModel->nombre_proyecto($proyecto),
            'detalles'=>$this->loginModel->detalles_proyecto($proyecto),
            'proyecto'=>$proyecto
            );
       
        echo view('gantt', $data);   
    }
    public function detalla_proyecto($numero){

        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        echo view('iniciorow');
        $data=array(
            'nombre_proyecto'=>$this->loginModel->nombre_proyecto($numero),
            'detalles'=>$this->loginModel->detalles_proyecto($numero),
            'participantes'=>$this->loginModel->proyectos_sin_asignar($numero)->getResult(),
            'proyecto'=>$numero                       
            );
        echo view('proyectos/detallado', $data);
        echo view('finrow');
        echo view("footer2");

        
    }
     public function detalla_proyecto2(){
        $data=array(
            'nombre_proyecto'=>$this->loginModel->nombre_proyecto($this->request->getPost("proyecto")),
            'detalles'=>$this->loginModel->detalles_proyecto($this->request->getPost("proyecto")),
            'participantes'=>$this->loginModel->proyectos_sin_asignar($this->request->getPost("proyecto"))->getResult(),
            'proyecto'=>$this->request->getPost("proyecto")                        
            );
        echo view('proyectos/detallado2', $data);
    }
    public function limpiar_archivo_proyecto(){
        $this->loginModel->limpiar_archivo_proyecto($this->request->getPost("subproyecto"));
    }
    public function ver_archivo_proyecto($num=NULL){
        $data=array('archivo'=>$this->loginModel->buscar_archivos_proyectos($num)->getResult());
        

        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data = array('nombre' => $this->loginModel->buscar_archivos_proyectos($num));
        echo view('proyectos/leer', $data);
        echo view('footer');
        
    }
    public function ver_archivo_8d($num,$tipo){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data = array('nombre' => $this->loginModel->buscar_archivo_8d($num,$tipo));

        echo view('8d/leer', $data);
        echo view('footer');
    }

    public function det_proyecto()
    {
        $data=array(
            'proyecto'=>$this->loginModel->nombre_proyecto($this->request->getPost('id_proyecto')),
            'subproyectos'=>$this->loginModel->subproyecto($this->request->getPost('id_subproyecto')),
            'id_subproyecto'=>$this->request->getPost('id_subproyecto')
            );
        echo view('proyectos/pendientes', $data);
    }
    public function subir2()
    {
        $carpetaAdjunta = "archivos_proyectos/";
        // Contar envían por el plugin

        $archivos = json_encode($_FILES);
        //print_r($archivos);
        preg_match('|id_subproyecto=(.*)"|sU', $archivos, $id_cliente);
        $id_subproyecto = str_replace('"', '', $id_cliente[0]);

        $Imagenes            = count(isset($_FILES[$id_subproyecto]['name']) ? $_FILES[$id_subproyecto]['name'] : 0);
        $infoImagenesSubidas = array();

        // El nombre y nombre temporal del archivo que vamos para adjuntar
        //$nombreArchivo  =    $id_cliente[1].$_FILES[$id_subproyecto]['file_ext'];
        $nombreArchivo=$id_cliente[1].".".pathinfo($_FILES[$id_subproyecto]['name'], PATHINFO_EXTENSION);
        $nombreTemporal = $_FILES[$id_subproyecto]['tmp_name'];

        $rutaArchivo = $carpetaAdjunta . $nombreArchivo;

        move_uploaded_file($nombreTemporal, $rutaArchivo);
        $rutaArchivo         = base_url() . $rutaArchivo;
        $infoImagenesSubidas = array("caption" => "$nombreArchivo", "height" => "120px", "url" => "borrar.php", "key" => $nombreArchivo);
        $ImagenesSubidas     = "<img  height='120px'  src='$rutaArchivo' class='file-preview-image'>";

        $arr = array("file_id" => 0, "overwriteInitial" => true, "initialPreviewConfig" => $infoImagenesSubidas,
            "initialPreview"       => $ImagenesSubidas);
        echo json_encode($arr);

        $data = array(
            'nombre_archivo' => $nombreArchivo,
            'id_subproyecto'        => $id_cliente[1],
        );

        $this->loginModel->carga_archivo_proyectos($data);

    }
    public function verifica_sala(){
        $cuantos=$this->loginModel->verfica_sala($_POST)->num_rows();
        if ($cuantos==0){
            echo view("btn_enviar");
        }else{
            print_r("<code>La sala de juntas disponible</code>");
        }
    }
    public function nueva_minuta()
     {
        $data=array(
            'usuarios'=> $this->loginModel->carga_usuarios(),
            'salas'=>$this->loginModel->salas(),
            );
        echo view('juntas/nueva_minuta', $data);
     }
    public function asigna (){
        $data=array(
            'todas_juntas' => $this->loginModel->lee_juntas2()
            );
        echo view("juntas/asigna_tema", $data);
    }
    public function guardar_actividad(){
        $data=array(
            'actividad'=>$this->request->getPost('actividad'),
            'participante'=>$this->request->getPost('participante'),
            'fecha'=>$this->request->getPost('fecha_compromiso'),
            'archivo'=>$this->request->getPost("archivo")
            );
       $this->loginModel->guarda_actividad($data);
    }
    public function terminar_tema(){
        $data=array(
            'id_actividad'=>$this->request->getPost('tema')
            );
        $this->loginModel->termina_actividad($data);
    }
    public function pendientes_juntas_sin(){
          $data = array(
            'tema_junta' => $this->loginModel->leer_tema_junta($this->request->getPost('id_tema')),
            'id_tema'    => $this->request->getPost('id_tema'),
         );
          echo view('alertas_sin', $data);

    }
    public function limpiar_archivo(){
        $data=array(
            'id_actividad'=>$this->request->getPost('tema')
            );
        $this->loginModel->limpiar_archivo($data);
    }
    public function elmina_actividad(){
        $data=array(
            'id_actividad'=>$this->request->getPost('tema')
            );
        $this->loginModel->elimina_actividad($data);
    }
    public function reagendar_activiad(){
        $this->loginModel->pedir_reagendar($_POST);
    }
    public function reagendar(){
        $data=array(
            'id_actividad'=>$this->request->getPost('tema'),
            'junta'=>$this->request->getPost('junta')
            );
        echo view('reagendar', $data);
     }
    public function guardar_reagendar(){
        $data=array(
            'id_actividad'=>$this->request->getPost('tema'),
            'fecha'=>$this->request->getPost('fecha')
            );
      $this->loginModel->reagendar($data);
    }
    public function terminar_minuta(){
        $data=array(
            'junta'=>$this->request->getPost('junta')
            );
        $this->loginModel->termina_minuta($data);
    }
    public function modificar_actividad(){
        $data=array(
            'tema'=>$this->request->getPost('tema'),
            'junta'=>$this->request->getPost('junta'),
            'usuarios'=> $this->loginModel->carga_usuarios(),
            'actividad'=>$this->loginModel->leer_actividad($this->request->getPost('tema'))

            );
        echo view('modificar_actividad', $data);
    }
    public function guarda_modificado(){
        $data=array(
            'actividad'=>$this->request->getPost('actividad'),
            'participante'=>$this->request->getPost('participante'),
            'fecha'=>$this->request->getPost('fecha_compromiso'),
            'archivo'=>$this->request->getPost("archivo"),
            'tema'=>$this->request->getPost('tema'),
            );
        $this->loginModel->guarda_modificado($data);

    }
    public function eliminar_minuta(){
        $data=array(
            'id_minuta'=>$this->request->getPost('junta')
            );
        $this->loginModel->elimina_minuta($data);
    }
    public function antes_participante(){
        $data=array(
            'todas_juntas' => $this->loginModel->lee_juntas2()
            );
        echo view('juntas/antes_participantes', $data);
    }
    public function carga_participantes(){
        $data=array(
            'junta'=>$this->request->getPost('junta'),
            'participantes'=>$this->loginModel->participantes_junta($this->request->getPost('junta'))
            );
        echo view('juntas/combocados', $data);
    }
    public function asistencia_asistente(){
        $data=array(
            'junta'=>$this->request->getPost("junta"),
            'id'=>$this->request->getPost("id"),
            'valor'=>$this->request->getPost("valor"),
        );
        $this->loginModel->asistencia_asistente($data);
    }
    public function guardar_participante(){
        $data=array(
            'participante'=>$this->request->getPost("participante"),
            'junta'=>$this->request->getPost("junta")
            );
        $this->loginModel->guardar_participante($data);
    }
    public function borra_participante(){

        $this->loginModel->borra_participante($this->request->getPost('usuario'),$this->request->getPost('junta'));
    }
    public function documentos_borrados(){
        echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        echo view('archivos/borrados');
        echo view('footer');
        
    }
    public function elimina_archivo(){
        $this->loginModel->elimina_archivo($this->request->getPost("documento"));
    }
    public function elimina_archivo2(){
        $this->loginModel->elimina_archivo2($this->request->getPost("documento"));
    }
    public function modifica_documento(){

            $this->loginModel->modifica_archivo($_POST);
    }
    public function modificar_permisos_documento(){
        
        $data=array(
            'subgrupos'             => $this->loginModel->leer_subrupos($this->request->getPost("empresa")),
            'descarga'              =>$this->loginModel->descarga_doc($this->request->getPost("documento")),
            'permisos'              =>$this->loginModel->permisos_doc($this->request->getPost("documento")),
            'id'                    =>$this->request->getPost("documento"),
            'empresas'              =>$this->loginModel->carga_empresas(),
            'responsables'          =>$this->loginModel->responsables(),
            'todo'                  =>$this->loginModel->todo_documentos($this->request->getPost("documento")),
            'empresa'               =>$this->request->getPost("empresa"),
            "menu"                  =>$this->loginModel->menu_de_empresa($this->request->getPost("empresa")),
            "submenus"              =>$this->loginModel->carga_submenu($this->loginModel->todo_documentos($this->request->getPost("documento"))[0]->menu),
            'departamento'          =>$this->loginModel->departamento(),
            'permisos2'             =>$this->loginModel->leer_subrupos($this->request->getPost("empresa")),
            );


        echo view("archivos/permisos_archivo", $data);
    }
    //pablo
    public function envio_correo_usuario(){
        $cuenta=$this->loginModel->info_correo($this->request->getPost("id"));
        $html='<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="x-apple-disable-message-reformatting"> 
    <title></title> 

    <!-- Web Font / @font-face : BEGIN -->
    <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->

    <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
    <!--[if mso]>
        <style>
            * {
                font-family: sans-serif !important;
            }
        </style>
    <![endif]-->

    <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
    <!--[if !mso]><!-->';
    $html=$html."
    <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
    <!--<![endif]-->

    <!-- Web Font / @font-face : END -->

    <!-- CSS Reset : BEGIN -->
    <style>

        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }";
        $html=$html.'

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],  /* iOS */
        .x-gmail-data-detectors,    /* Gmail */
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
        .a6S {
           display: none !important;
           opacity: 0.01 !important;
       }
       
       img.g-img + div {
           display: none !important;
       }

       /* What it does: Prevents underlining the button text in Windows 10 */
        .button-link {
            text-decoration: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
       
        /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) { /* iPhone 6 and 6+ */
            .email-container {
                min-width: 375px !important;
            }
        }

        @media screen and (max-width: 480px) {
            /* What it does: Forces Gmail app to display email full width */
            u ~ div .email-container {
                min-width: 100vw;
                width: 100% !important;
            }
        }

    </style>
    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>

        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        /* Media Queries */
        @media screen and (max-width: 600px) {

            .email-container {
                width: 100% !important;
                margin: auto !important;
            }

            /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
            .fluid {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }

            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }

            /* What it does: Adjust typography on small screens to improve readability */
            .email-container p {
                font-size: 17px !important;
            }
        }

    </style>
    <!-- Progressive Enhancements : END -->

    <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->

</head>
<body width="100%"  style="margin: 0; mso-line-height-rule: exactly;">
    <center style="width: 100%; background-image: url(';

    $html=$html."'".base_url()."assets/img/mail.png'";
    $html=$html.') ;background-size: 100% 100%; text-align: left;">

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
        ';
        $html=$html."
           
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <!-- Email Header : BEGIN -->
        
        <!-- Email Header : END -->

        <!-- Email Body : BEGIN -->";
        $html=$html.'
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">

            <!-- Hero Image, Flush : BEGIN -->
            <tr>
                <td height="400px" align="center">
                   
                    
                </td>
            </tr>
            <!-- Hero Image, Flush : END -->

            <!-- 1 Column Text + Button : BEGIN -->
            <tr>
                <td bgcolor="#ffffff" style="padding: 40px 40px 20px; text-align: center;">
                    <h1 style="margin: 0; font-family: sans-serif; font-size: 24px; line-height: 125%; color: #333333; font-weight: normal;">Notificacion de Usuario</h1>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 0 40px 40px; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555; text-align: center;">
                    <p style="margin: 0;">Estimado(a): '.strtoupper($cuenta[0]->nombre).'</p>
                    <p style="margin: 0;">Cambie su '.utf8_decode("contraseña").' inmediatamente.</p>
                    <p style="margin: 0;">Usuario: '.$cuenta[0]->usuario.'</p>
                    <p style="margin: 0;">'.utf8_decode("contraseña").': '.$cuenta[0]->pass.'</p>
                    <p style="margin: 0;">La liga para acceder al sistema es: <a href="http://ns1.donanadm.com.mx">ns1.donanadm.com.mx</a></p>
                    <p style="margin: 0;">Para uso del sistema favor de consultar los tutoriales adicionados al mismo.</p>
                </td>
            </tr>
            
            
        </tr>
        <!-- Background Image with Text : END -->
</table>
 
    </center>
</body>
</html>';
        

        /*// library


        $config = array();

        $config['useragent']           = "CodeIgniter";
        $config['mailpath']            = "/usr/bin/sendmail"; 
        $config['protocol']            = "mail";
        $config['smtp_host']           = env('email.smtpHost');
        $config['smtp_port']           = "25";
        $config['smtp_crypto']         = "tls";
        $config['smtp_user']           = env('email.smtpUser');
        $config['smtp_pass']           = env('email.smtpPass');
        $config['mailtype'] = 'html';
        $config['charset']  = 'iso-8859-1';
        $config['newline']  = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        
        $this->email->from(env('email.fromEmail'));
        $this->email->to($cuenta[0]->correo);
        $this->email->subject('Acceso Sistema Control Documental');
        
        $this->email->message($html);
        $this->email->send();
        var_dump($this->email->print_debugger());
    */
        require 'PHPMailer/PHPMailerAutoload.php';
        $host = env('email.smtpHost');
    $username = env('email.smtpUser');
    $password = env('email.smtpPass');

    $subject = 'Acceso Sistema Control Documental';

    $message = $html;

    $email = env('email.fromEmail');

    $name = 'Qanry';



     $mail = new PHPMailer;
            
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->SMTPDebug = 2;
     $mail->isSMTP(); 
    $mail->SMTPAuth = TRUE;
    $mail->Mailer = 'smtp';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;  
    $mail->Host = $host;

    $mail->Username = $username;
    $mail->Password = $password;

    $mail->From = $email;
    $mail->FromName = $name;

    // Add receive email address
    $mail->addAddress($cuenta[0]->correo);

    $mail->isHTML(true);

    $mail->Subject = $subject;

    $mail->Body    = $html;


    $mail->send();
    echo 'Error: ', $mail->ErrorInfo;

        
    }
    function correo_minutas(){
        $asistencia=$this->loginModel->asistencia_juntas($this->request->getPost("junta"))->getResult();
        foreach ($asistencia as $key) {
           
        
            $html='<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8"> <!-- utf-8 works for most cases -->
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="x-apple-disable-message-reformatting"> 
    <title></title> 

    <!-- Web Font / @font-face : BEGIN -->
    <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->

    <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
    <!--[if mso]>
        <style>
            * {
                font-family: sans-serif !important;
            }
        </style>
    <![endif]-->

    <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
    <!--[if !mso]><!-->';
    $html=$html."
    <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
    <!--<![endif]-->

    <!-- Web Font / @font-face : END -->

    <!-- CSS Reset : BEGIN -->
    <style>

        /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }";
        $html=$html.'

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }
        table table table {
            table-layout: auto;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode:bicubic;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],  /* iOS */
        .x-gmail-data-detectors,    /* Gmail */
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
        .a6S {
           display: none !important;
           opacity: 0.01 !important;
       }
       
       img.g-img + div {
           display: none !important;
       }

       /* What it does: Prevents underlining the button text in Windows 10 */
        .button-link {
            text-decoration: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
       
        /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) { /* iPhone 6 and 6+ */
            .email-container {
                min-width: 375px !important;
            }
        }

        @media screen and (max-width: 480px) {
            /* What it does: Forces Gmail app to display email full width */
            u ~ div .email-container {
                min-width: 100vw;
                width: 100% !important;
            }
        }

    </style>
    <!-- CSS Reset : END -->

    <!-- Progressive Enhancements : BEGIN -->
    <style>

        /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        /* Media Queries */
        @media screen and (max-width: 600px) {

            .email-container {
                width: 100% !important;
                margin: auto !important;
            }

            /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
            .fluid {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;
            }

            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }

            /* What it does: Adjust typography on small screens to improve readability */
            .email-container p {
                font-size: 17px !important;
            }
        }

    </style>
    <!-- Progressive Enhancements : END -->

    <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
    <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->

</head>
<body width="100%" style="margin: 0; mso-line-height-rule: exactly;">
    <center style="width: 100%; background-image: url(';

    $html=$html."'".base_url()."assets/img/mail.png'";
    $html=$html.') ;background-size: 100% 100%; text-align: left;">

        <!-- Visually Hidden Preheader Text : BEGIN -->
        <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
        ';
        $html=$html."
            
        </div>
        <!-- Visually Hidden Preheader Text : END -->

        <!-- Email Header : BEGIN -->
        
        <!-- Email Header : END -->

        <!-- Email Body : BEGIN -->";
        $html=$html.'
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">

            <!-- Hero Image, Flush : BEGIN -->
            <tr>
                <td height="400px" align="center">

                    
                </td>
            </tr>
            <!-- Hero Image, Flush : END -->

            <!-- 1 Column Text + Button : BEGIN -->
            <tr>
                <td bgcolor="#ffffff" style="padding: 40px 40px 20px; text-align: center;">
                    <h1 style="margin: 0; font-family: sans-serif; font-size: 24px; line-height: 125%; color: #333333; font-weight: normal;">Notificacion de Usuario</h1>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 0 40px 40px; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555; text-align: center;">
                    <p style="margin: 0;">Estimado(a): '.strtoupper($key->nombre).'</p>
                    <p style="margin: 0;">Es usted participante de la junta '.strtoupper($key->tema).' que se efectuo con fecha  '.$key->fecha.' en '.$key->lugar.'</p>
                    
                    <p style="margin: 0;">La liga para acceder al sistema es: <a href="http://ns1.donanadm.com.mx">ns1.donanadm.com.mx</a></p>
                    <p style="margin: 0;">Para uso del sistema favor de consultar los tutoriales adicionados al mismo.</p>
                </td>
            </tr>
            
            
        </tr>
        <!-- Background Image with Text : END -->
</table>
 
    </center>
</body>
</html>';
        /*
        // library


        $config = array();

        $config['useragent']           = "CodeIgniter";
        $config['mailpath']            = "/usr/bin/sendmail"; 
        $config['protocol']            = "mail";
        $config['smtp_host']           = env('email.smtpHost');
        $config['smtp_port']           = "587";
        $config['smtp_crypto']         = "tls";
        $config['smtp_user']           = env('email.smtpUser');
        $config['smtp_pass']           = env('email.smtpPass');
        $config['mailtype'] = 'html';
        $config['charset']  = 'iso-8859-1';
        $config['newline']  = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        
        $this->email->from(env('email.fromEmail'));
        $this->email->to($key->correo);
        $this->email->subject('Minutas Qanry');
        
        $this->email->message($html);
        $this->email->send();
        var_dump($this->email->print_debugger());

        */
           require 'PHPMailer/PHPMailerAutoload.php';
        $host = env('email.smtpHost');
    $username = env('email.smtpUser');
    $password = env('email.smtpPass');

    $subject = 'Minutas Qanry';

    $message = $html;

    $email = env('email.fromEmail');

    $name = 'Qanry';



     $mail = new PHPMailer;
            
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->SMTPDebug = 2;
     $mail->isSMTP(); 
    $mail->SMTPAuth = TRUE;
    $mail->Mailer = 'smtp';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;  
    $mail->Host = $host;

    $mail->Username = $username;
    $mail->Password = $password;

    $mail->From = $email;
    $mail->FromName = $name;

    // Add receive email address
    $mail->addAddress($cuenta[0]->correo);

    $mail->isHTML(true);

    $mail->Subject = $subject;

    $mail->Body    = $html;


    $mail->send();
    echo 'Error: ', $mail->ErrorInfo;

    }

    }
    public function usuario_lista(){
        $list = model(UsuarioModel::class)->get_datatables();
        $data = array();
        foreach ($list as $usuario) {
            $row = array();
            $row[] = $usuario->nombre;
            $row[] = $usuario->usuario;
            $row[] = $usuario->tipo;
            $row[] = $usuario->juntas;

            $id = esc((string) $usuario->id, 'js');
            $row[] = '<button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="usuario_editar(\''.$id.'\')">Editar</button>'
                . '<button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="usuario_eliminar(\''.$id.'\')">Eliminar</button>'
                . '<button type="button" class="btn btn-sm btn-outline-secondary" onclick="envio_email(\''.$id.'\')">Email</button>';

            $data[] = $row;
        }
        $output = array(
                        "draw" => (int) ($this->request->getPost('draw') ?? 0),
                        "recordsTotal" => model(UsuarioModel::class)->count_all(),
                        "recordsFiltered" => model(UsuarioModel::class)->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function usuario_editar($id){
        $data = model(UsuarioModel::class)->get_by_id($id);
        echo json_encode($data);
    }

    public function permisos_usuario($id){
         $data = model(UsuarioModel::class)->permisos_id($id);
         
        echo json_encode($data);
    }
    public function usuario_anadir(){
        $data = array(
                'nombre' => $this->request->getPost('nombre'),
                'usuario' => $this->request->getPost('usuario'),
                'tipo' => $this->request->getPost('tipo'),
                'juntas' => $this->request->getPost('juntas'),
            );
        $insert = model(UsuarioModel::class)->saveUsuario($data);
        echo json_encode(array("status" => TRUE));
    }
    public function vista_estructura(){
        $mar['pas'] = $this->loginModel->estructura_todo($this->request->getPost("id"));
        $mar['id_empresa']=$this->request->getPost("id");
        echo view('diagrama', $mar);
    }
    public function agrega_usuario()
    {
        $data = array('nivel'=>$this->request->getPost('nivel'),'nombre' => $this->request->getPost('nombre'), 'usuario' => $this->request->getPost('usuario'), 'pass' => $this->request->getPost('pass'), 'tipo' => $this->request->getPost('tipo'), 'permisos' => $this->request->getPost('permisos'),'minutas'=>$this->request->getPost('minutas'),'puesto'=>$this->request->getPost("puesto"), 'departamento'=>$this->request->getPost("departamento"),'doc'=>$this->request->getPost('doc'),'reportes'=>$this->request->getPost("reportes"),'email'=>$this->request->getPost("email"));
        $insert = model(UsuarioModel::class)->saveUsuario($data);
        echo json_encode(array("status" => TRUE));
    }
    public function usuario_actualizar(){
       $data = array('nivel'=>$this->request->getPost('nivel'),'nombre' => $this->request->getPost('nombre'), 'usuario' => $this->request->getPost('usuario'), 'pass' => $this->request->getPost('pass'), 'tipo' => $this->request->getPost('tipo'), 'permisos' => $this->request->getPost('permisos'),'minutas'=>$this->request->getPost('minutas'),'id' => $this->request->getPost('id'),'puesto'=>$this->request->getPost("puesto"), 'departamento'=>$this->request->getPost("departamento"),'doc'=>$this->request->getPost('doc'),'reportes'=>$this->request->getPost("reportes"),'email'=>$this->request->getPost("email"));

        model(UsuarioModel::class)->updateUsuario($data);

        echo json_encode(array("status" => TRUE));
    }
    public function tutoriales(){
         echo view('head');
        
        echo view('menu');
        echo view('herramienta');
        echo view('inicio_cuerpo');
        $data=array('videos'=>$this->loginModel->video());
        echo view("tabla_tutoriales", $data);
        echo view('footer');
    }
    public function usuario_eliminar($id){

        model(UsuarioModel::class)->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function usuario_por_id($id){
        $data['output'] = model(UsuarioModel::class)->get_by_id_view($id);
        echo view('view_Detail', $data);
    }
    public function empresas_lista()
    {
        $list = model(EmpresaModel::class)->get_datatables();
        $data = array();
        foreach ($list as $empresas) {
            $row = array();
            $row[] = $empresas->nombre;
            $row[] = $empresas->calle;
            $row[] = $empresas->numero_ext;
            $row[] = $empresas->numero_int;
            $row[] = $empresas->colonia;
            $row[] = $empresas->ciudad;
            $row[] = $empresas->estado;
            $row[] = $empresas->cp;
            $row[] = $empresas->rfc;
            $row[] = $empresas->apoderado;

            $id = esc((string) $empresas->id, 'js');
            $row[] = '<button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="empresas_editar(\''.$id.'\')">Editar</button>'
                . '<button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="empresas_eliminar(\''.$id.'\')">Eliminar</button>'
                . '<button type="button" class="btn btn-sm btn-outline-secondary" onclick="empresas_ver(\''.$id.'\')">Ver</button>';

            $data[] = $row;
        }
        $output = array(
                        "draw" => (int) ($this->request->getPost('draw') ?? 0),
                        "recordsTotal" => model(EmpresaModel::class)->count_all(),
                        "recordsFiltered" => model(EmpresaModel::class)->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }


    public function empresas_editar($id)
    {
        $data = model(EmpresaModel::class)->get_by_id($id);
        echo json_encode($data);
    }

    public function empresas_anadir()
    {   

        //obtenemos el archivo a subir
        if (isset($_FILES['archivo'])){
            $file = $_FILES['archivo']['name'];
            if(!is_dir("files/")) 
                mkdir("files/", 0777);
            if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"logos/".$file))
            {
               sleep(3);//retrasamos la petición 3 segundos
                $data = array(
                    'nombre'     => $this->request->getPost('nombre_empresa'),
                    'calle'      => $this->request->getPost('calle'),
                    'numero_ext' => $this->request->getPost('numero_ext'),
                    'numero_int' => $this->request->getPost('numero_int'),
                    'colonia'    => $this->request->getPost('colonia'),
                    'ciudad'     => $this->request->getPost('ciudad'),
                    'estado'     => $this->request->getPost('estado'),
                    'cp'         => $this->request->getPost('cp'),
                    'rfc'        => $this->request->getPost('rfc'),
                    'apoderado'  => $this->request->getPost('apoderado'),
                    'logo'       => $file,
                    );
                    $insert = model(EmpresaModel::class)->saveEmpresa($data);
                    echo json_encode(array("status" => TRUE));
            }
        }else{
             $data = array(
                    'nombre'     => $this->request->getPost('nombre_empresa'),
                    'calle'      => $this->request->getPost('calle'),
                    'numero_ext' => $this->request->getPost('numero_ext'),
                    'numero_int' => $this->request->getPost('numero_int'),
                    'colonia'    => $this->request->getPost('colonia'),
                    'ciudad'     => $this->request->getPost('ciudad'),
                    'estado'     => $this->request->getPost('estado'),
                    'cp'         => $this->request->getPost('cp'),
                    'rfc'        => $this->request->getPost('rfc'),
                    'apoderado'  => $this->request->getPost('apoderado'),
                    'logo'       => "",
                    );
                    $insert = model(EmpresaModel::class)->saveEmpresa($data);
                    echo json_encode(array("status" => TRUE));
        }
    }

    public function empresas_actualizar()
    {
        $data = array(
                'nombre' => $this->request->getPost('nombre_empresa'),
                'calle' => $this->request->getPost('calle'),
                'numero_ext' => $this->request->getPost('numero_ext'),
                'numero_int' => $this->request->getPost('numero_int'),
                'colonia' => $this->request->getPost('colonia'),
                'ciudad' => $this->request->getPost('ciudad'),
                'estado' => $this->request->getPost('estado'),
                'cp' => $this->request->getPost('cp'),
                'rfc' => $this->request->getPost('rfc'),
                'apoderado' => $this->request->getPost('apoderado'),
            );
        model(EmpresaModel::class)->updateEmpresa(array('id' => $this->request->getPost('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function empresas_eliminar($id)
    {

        model(EmpresaModel::class)->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
        
    public function empresas_por_id($id){
        $data['output'] = $this->empresa->get_by_id_view($id);
        echo view('view_Detail', $data);
    }
    public function pedir_proyecto(){
        $data=array(
            'tema'=>$this->request->getPost("tema"),
            'tipo'=>$this->request->getPost('tipo')
            );
        $this->loginModel->pedir_proyecto($data);
    }
}

//
