<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $DBGroup = 'default';

    /** @var \CodeIgniter\Database\BaseConnection */
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
        date_default_timezone_set('America/Mexico_City');
    }

    protected function loggedIn(?string $key = null)
    {
        $data = session()->get('logged_in') ?? [];
        if ($key === null) {
            return $data;
        }
        return $data[$key] ?? null;
    }

        public function login($username, $password)
    {
        $row = $this->db->table('usuario')
            ->select('id, nombre, tipo, juntas, pass')
            ->where('usuario', $username)
            ->get()
            ->getRowArray();

        if ($row === null) {
            return false;
        }

        $stored = (string) $row['pass'];
        $info   = password_get_info($stored);
        $ok     = false;

        if (($info['algoName'] ?? 'unknown') !== 'unknown') {
            $ok = password_verify((string) $password, $stored);
        } else {
            $ok = hash_equals($stored, (string) $password);
            if ($ok) {
                // Migra a hash moderno
                $this->db->table('usuario')->where('id', $row['id'])->update([
                    'pass' => password_hash((string) $password, PASSWORD_DEFAULT),
                ]);
            }
        }

        if (! $ok) {
            return false;
        }

        return [[
            'id'     => $row['id'],
            'nombre' => $row['nombre'],
            'tipo'   => $row['tipo'],
            'juntas' => $row['juntas'],
        ]];
    }
    public function alertas_avisos(){
        $cadena="select mensaje, id from avisos where id not in (select aviso from visto_avisos where usuario='".$this->loggedIn('iduser')."')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function elimina_aviso($id){
        $cadena="update avisos set activo='NO' where id='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return "SI";
        } else {
            return "NO";
        }
    }
    public function modifica_aviso($data){
        $cadena="update avisos set mensaje='".$data["mensaje"]."' where id='".$data["id"]."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return "SI";
        } else {
            return "NO";
        }
    }
    public function guarda_aviso($data){
        $cadena="insert into avisos (mensaje) values ('".$data["mensaje"]."')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return "SI";
        } else {
            return "NO";
        }
    }
    public function busca_aviso($id){
        $cadena="select mensaje from avisos where id='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function  lista_avisos(){
        $cadena="select id, mensaje, activo  from avisos";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function salir($id){
        $cadena="insert into checador (usuario, fecha, hora, movimiento) values ('".$id."', CURDATE(), DATE_FORMAT(NOW( ), '%H:%i:%S' ) ,'SALIDA')";
        $query=$this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function entrada($id){
        
        $cadena="insert into checador (usuario, fecha, hora, movimiento) values ('".$id."', CURDATE(), DATE_FORMAT(NOW( ), '%H:%i:%S' ) ,'ENTRADA')";
        $query=$this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function eliminar_solicitud($id){
        $cadena="delete from solicitud where id_solicitud='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function lista_solicitudes(){
        $cadena="select solicitud.folio, solicitud.tipo, solicitud.codigo,solicitud.nombre, solicitud.id_solicitud, usuario.nombre as solicitante, usuario.departamento from solicitud inner join usuario on solicitud.solicitante=usuario.id";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function asigna_folio_solicitud($data){
        $cadena="select f_".strtolower ($data["tipo"])." as folio from configuracion";
        $query  = $this->db->query($cadena)->getResult();
        $folio="";
        foreach ($query as $key) {
            $folio=$key->folio;
        }
        $cadena="update solicitud set folio='".$folio."' where id_solicitud='".$data["id"]."'";

        $query  = $this->db->query($cadena);

        $cadena="update configuracion set  f_".strtolower ($data["tipo"])."='".($folio+1)."'";
        $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
        //print_r($data);
    }
    public function responsables(){
       
        $cadena="select nombre, id from usuario order by nombre";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function tracking($id){
        $contador=0;
        $cadena="select tipo from documentos where id='".$id."'";
        $query=$this->db->query($cadena)->getResult();
        if ($query[0]->tipo=="D" or $query[0]->tipo=="POL" or $query[0]->tipo=="OR"){
            $cadena="(select usuario.nombre, verificacion.estatus, 'VERIFICACION' as tipo from verificacion inner join usuario on verificacion.id_usuario=usuario.id where verificacion.id_documento='".$id."') UNION (select usuario.nombre, documentos.estatus,'AUTORIZACION' as tipo from documentos inner join responsables on documentos.tipo=responsables.siglas inner join usuario on responsables.usuario=usuario.id where documentos.id='".$id."')";
        }else{
            if ($query[0]->tipo=="F" or $query[0]->tipo=="I" or $query[0]->tipo=="MP" or $query[0]->tipo=="T"){
                $cadena="select usuario.nombre, verificacion.estatus, 'VERIFICACION' as tipo from verificacion inner join usuario on verificacion.id_usuario=usuario.id where verificacion.id_documento='".$id."'";
            }else{
                $cadena="(select usuario.nombre, verificacion.estatus, 'VERIFICACION' as tipo from verificacion inner join usuario on verificacion.id_usuario=usuario.id where verificacion.id_documento='".$id."') UNION (select usuario.nombre,  documentos.estatus, 'AUTORIZACION' as tipo from documentos inner join responsables on documentos.departamento=responsables.departamento and documentos.tipo=responsables.siglas inner join usuario on responsables.usuario=usuario.id where documentos.id='".$id."')";    
            }
        }
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
        


    }
    public function proximos_eventos(){
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '+5 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        $cadena="select titulo, fecha_inicio from eventos where activo='SI' and fecha_inicio BETWEEN '".$fecha."' and '".$nuevafecha."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function ver_evento($id){
        $cadena="select descripcion from eventos where id_evento='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function modifica_solicitud($data){
        $cadena="update solicitud set codigo='".$data["codigo"]."', nombre='".$data["nombre"]."' where id_solicitud='".$data["folio"]."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function  eventos(){
        $cadena="select * from eventos where activo='SI'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function asistencia_juntas($id){
        $cadena="select juntas.tema, juntas.lugar, juntas.fecha, usuario.nombre, usuario.correo from juntas inner join integrantes on juntas.id_junta=integrantes.id_junta inner join usuario on integrantes.id_usuario=usuario.id where juntas.id_junta='".$id."' and integrantes.asistencia='SI'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function asistencia_asistente($data){
        $cadena="update integrantes set asistencia='".$data["valor"]."' where id_usuario='".$data["id"]."' and id_junta='".$data["junta"]."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function general_solicitud($id){
        $cadena="select solicitud.folio, solicitud.tipo, solicitud.fecha, solicitud.codigo,solicitud.nombre, solicitud.id_solicitud,solicitud.tiempo,solicitud.especificar, usuario.nombre as solicitante, usuario.departamento from solicitud inner join usuario on solicitud.solicitante=usuario.id where solicitud.id_solicitud='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function lista_business(){
        $cadena="select business.id_business, business.fecha, business.analisis, business.ventaja, usuario.nombre from business inner join usuario on business.solicito=usuario.id";
        
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function termia_proyecto($id){
        $cadena="update subproyecto set terminado='SI' where id_proyecto='".$id."'";
        $this->db->query($cadena);
        $cadena="update proyecto set f_fin=CURDATE() where id_proyecto='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function enviar_mensaje($data){
        $cadena="select id from usuario where usuario='".$data["sentto"]."' ";
        $query  = $this->db->query($cadena)->getResult();
        $id_enviado="";
        foreach ($query as $key) {
            $id_enviado=$key->id;
        }
        $cadena="insert into chat (usuario,  message, sent_on, envia) values  ('".$id_enviado."','".$data["mensaje"]."',NOW(),'".$this->loggedIn('iduser')."')";
 
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function get_messages_count (){
        $cadena="select envia from chat where usuario='".$this->loggedIn('iduser')."' and leido='NO' GROUP by envia";
      
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function busca_mensajes($limite){
        $cadena="selet * from chat where usuario='".$this->loggedIn('iduser')."' and leido='NO'";
         $query  = $this->db->query($cadena);

        if (!empty($query)) {
            if ($query->getNumRows()>0){
                return $query;
            }else{
                return false;
            }
            
        } else {
            return false;
        }
    }
    public  function get_mensaje($id){
        $cadena="select id from usuario where usuario='".$id."'";
        $query  = $this->db->query($cadena)->getResult();
        $id_enviado="";
        foreach ($query as $key) {
            $id_enviado=$key->id;
        }
        $cadena="select chat.message,chat.envia, chat.sent_on, usuario.nombre, usuario.usuario from chat inner join usuario on chat.usuario=usuario.id where (chat.envia='".$this->loggedIn('iduser')."' and chat.usuario='".$id_enviado."') or (chat.envia='".$id_enviado."' and chat.usuario='".$this->loggedIn('iduser')."') order by chat.chat_id";
        //print_r($cadena);
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function niveles(){
        $cadena="select nivel from niveles";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function cambia_mensajes($envia){
        $cadena="update chat set leido='SI' where envia='".$envia."' and usuario='".$this->loggedIn('iduser')."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function reorden(){
        $tipo=$this->loggedIn('tipo');
        if ($tipo=="admin"){
           $cadena="select DISTINCT chat.envia, chat.usuario as enviado,usuario.id,usuario.usuario, usuario.nombre, usuario.img from usuario left join chat on usuario.id=chat.envia order by FIELD (chat.usuario,'".$this->loggedIn('iduser')."') desc";
        }else{
            $cadena="select DISTINCT chat.envia, chat.usuario as enviado, usuario.id,usuario.usuario, usuario.nombre, usuario.img from usuario left join chat on usuario.id=chat.envia where usuario.tipo='admin' order by FIELD (chat.usuario,'".$this->loggedIn('iduser')."') desc";
        }
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function extra_admin(){

        $tipo=$this->loggedIn('tipo');
        if ($tipo=="admin"){
            $cadena="select * from usuario order by nombre";
        }else{
            $cadena="select * from usuario where tipo='admin' order by nombre";
        }

        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function minutas_pendientes($fecha,$tipo,$moderador){
            if ($tipo=="todos"){
                $cadena="select temas_juntas.id_tema, juntas.tema, temas_juntas.tema as actividad, temas_juntas.fecha_compromiso, usuario.nombre from juntas inner join temas_juntas on juntas.id_junta=temas_juntas.id_junta  inner join usuario on temas_juntas.id_usuario_encargado=usuario.id where temas_juntas.fecha_compromiso<='".$fecha."' and temas_juntas.terminado='NO'";
            }else{
                if ($moderador=="NO"){
                    $cadena="select temas_juntas.id_tema, juntas.tema, temas_juntas.tema as actividad, temas_juntas.fecha_compromiso, usuario.nombre from juntas inner join temas_juntas on juntas.id_junta=temas_juntas.id_junta  inner join usuario on temas_juntas.id_usuario_encargado=usuario.id where temas_juntas.fecha_compromiso<='".$fecha."' and temas_juntas.terminado='NO' and temas_juntas.id_usuario_encargado='".$tipo."'";
                }else{
                    $cadena="select temas_juntas.id_tema, juntas.tema, temas_juntas.tema as actividad, temas_juntas.fecha_compromiso, usuario.nombre from juntas inner join temas_juntas on juntas.id_junta=temas_juntas.id_junta  inner join usuario on temas_juntas.id_usuario_encargado=usuario.id where temas_juntas.fecha_compromiso<='".$fecha."' and temas_juntas.terminado='NO' and juntas.impartidor='".$tipo."'";
                }
            }
      
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function prueba(){
        $cadena="INSERT INTO `responsables` (`id_departamento`, `departamento`, `usuario`, `siglas`) VALUES (NULL, 'Direccion General', '8', 'OR');";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            print_r("hecho <br />");
        } else {
            print_r("no, hecho <br />");
        }
        
       
        

    }
    public function reactivar($data){
        $cadena="insert into reactiva_subproyectos (nota, id_subproyecto,fecha, id_usuario) values ('".$data["nota"]."','".$data["subproyecto"]."', CURDATE(), '".$this->loggedIn('iduser')."')";
        $query  = $this->db->query($cadena);
        $cadena="update subproyecto set terminado='NO' where id_subproyecto='".$data["subproyecto"]."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_archivo_junta($data)
    {
        $cadena = "insert into archivos_juntas (id_tema, archivo) values ('" . $data['id_tema'] . "','" . $data["nombre_archivo"] . "')";

        $query  = $this->db->query($cadena);

        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_nombre_grupo($id)
    {
        $cadena = "select nomber, empresa from grupos where id='" . $id . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_nombre_subgrupo($id)
    {
        $cadena = "select nombre from subgrupos where id='" . $id . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function borrar_subproyecto($subproyecto){
        $cadena="delete from subproyecto where id_subproyecto='".$subproyecto."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
   
    public function general_business2($folio){
         $cadena="select * from  business where id_business='".$folio."'";
         
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query->getResult();
        }else{
            return false;
        }   
    }
    public function general_business($folio){
       // $cadena="select * from  business where id_business='".$folio."'";
         $cadena="select business.id_business, business.fecha, business.analisis, business.ventaja, usuario.nombre from business inner join usuario on business.solicito=usuario.id where business.id_business='".$folio."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query->getResult();
        }else{
            return false;
        }   
    }
    public function alter_select ($folio){
        $cadena="select alternativas.alternativa from business inner join alternativas on business.seleccion=alternativas.id_alternativa where business.id_business='".$folio."'";
         $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query->getResult();
        }else{
            return false;
        }
    }
    public function elimina_case($id){
        $cadena="delete from business where id_business='".$id."'";
        $query=$this->db->query($cadena);
        $cadena="delete from alternativas where id_business='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        } 
    }
    public function departamento(){
        $cadena="select distinct departamento from responsables";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query->getResult();
        }else{
            return false;
        }
    }
    public function guardar_mod_mejora($data,$id){
        $cadena="update mejora set descripcion='".$data["problema"]."', beneficios='".$data["beneficio"]."', solicitante='".$data["usuario"]."' where id_mejora='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function guardar_mejora($data){
        $cadena="insert into mejora (descripcion, beneficios,fecha,solicitante,atendido,activo) values ('".$data["problema"]."', '".$data["beneficio"]."', CURDATE(),'".$data["usuario"]."','NO', 'SI')";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function elimina_mejora($id){
        $cadena="delete from mejora where id_mejora='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function general_mejora($id){
        $cadena="select mejora.id_mejora, mejora.solicitante,mejora.descripcion, mejora.beneficios, mejora.fecha, usuario.nombre, mejora.atendido, mejora.activo from mejora inner join usuario on mejora.solicitante=usuario.id where mejora.id_mejora='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query->getResult();
        }else{
            return false;
        }
    }
    public function lista_mejora(){
        $cadena="select mejora.id_mejora, mejora.fecha, usuario.nombre, mejora.atendido, mejora.activo from mejora inner join usuario on mejora.solicitante=usuario.id";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query->getResult();
        }else{
            return false;
        }
    }
    public function modifica_business_case($data){

        $cadena="update business set analisis='".$data["hechos"]."', ventaja='".$data["define_ventaja"]."', seleccion='".$data["acepta"]."', solicito='".$data["usuario"]."' where id_business='".$data["folio"]."'";
     
        $query=$this->db->query($cadena);
        $cadena="update alternativas set id_business='".$data["folio"]."' where id_business='0'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function guardar_business($data){

        $cadena="insert into business (analisis, ventaja, fecha,seleccion, solicito) values ('".$data["hechos"]."', '".$data["define_ventaja"]."',CURDATE(),'".$data["acepta"]."','".$data["usuario"]."')";
        
        $query=$this->db->query($cadena);
        $cadena="select id_business from business where analisis='".$data["hechos"]."'";
        $query=$this->db->query($cadena)->getResult();
        $folio=0;
        foreach ($query as $key) {
            $folio=$key->id_business;
        }
        $cadena="update alternativas set id_business='".$folio."' where id_business='0'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function elimina_alternativa($id){
        $cadena="delete from alternativas where id_alternativa='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function cargas_raci_responsable2(){

    }
    public function agregar_alternativa($data){
        $cadena="insert into alternativas (alternativa, id_business) values ('".$data."','0')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function alternativas($folio){
        $cadena="select * from alternativas where id_business='".$folio."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_empresas()
    {
        $cadena = "select * from empresas order by nombre";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function nombre_empresa($numero)
    {
        $cadena = "select nombre, logo from empresas where id='" . $numero . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_archivos3($subgrupo)
    {
        $cadena = "select documentos.descarga, documentos.nombre, documentos.id from documentos inner join permiso_doc on documentos.id=permiso_doc.id_documento where permiso_doc.id_subgrupo='" . $subgrupo . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function guarda_notas($nota, $tema){
        $cadena="insert into notas (id_tema_junta, nota, fecha) values ('".$tema."','".$nota."', CURDATE())";
         $this->db->query($cadena);
    }
    public function lista_notas2($subproyecto){
         $cadena="select fecha, nota from notas_proyectos where id_subproyecto='".$subproyecto."'";
       

        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function lista_notas($tema){
        $cadena="select fecha, nota from notas where id_tema_junta='".$tema."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function reporte_proyectos($fecha,$tipo){
        if ($tipo=="todos"){
            $cadena="select subproyecto.nombre as subproyecto, subproyecto.f_inicio, subproyecto.f_fin, usuario.nombre, proyecto.nombre_proyecto as proyecto from subproyecto inner join proyecto on subproyecto.id_proyecto=proyecto.id_proyecto inner join usuario on subproyecto.id_usuario=usuario.id where subproyecto.f_fin<='".$fecha."' and terminado='NO'";
        }else{
            $cadena="select subproyecto.nombre as subproyecto, subproyecto.f_inicio, subproyecto.f_fin, usuario.nombre, proyecto.nombre_proyecto as proyecto from subproyecto inner join proyecto on subproyecto.id_proyecto=proyecto.id_proyecto inner join usuario on subproyecto.id_usuario=usuario.id where subproyecto.f_fin<='".$fecha."' and terminado='NO' and subproyecto.id_usuario='".$tipo."'";
        }
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function lista_documentos($id_documento,$tipo)
    {
            $cadena = "select id, nombre, descarga,tipo, departamento from documentos where id='" . $id_documento . "' and (tipo='".$tipo."'or  nombre like '%-".$tipo."-%')  and estatus='A'";

        
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

    /**
     * Lista documentos autorizados del usuario filtrados por tipo (POL, D, P, etc.).
     * Evita que la vista llame al modelo (CI3 → CI4).
     *
     * @return list<object>
     */
    public function documentosPorTipo(string $tipo): array
    {
        $ids = $this->carga_archivos2();
        $lista = [];

        if ($ids === false) {
            return $lista;
        }

        foreach ($ids->getResult() as $documento) {
            $rows = $this->lista_documentos($documento->id_documento, $tipo);
            if ($rows === false) {
                continue;
            }
            foreach ($rows->getResult() as $row) {
                $lista[] = $row;
            }
        }

        return $lista;
    }

    public function carga_archivos2()
    {
        $tipo=$this->loggedIn('tipo');
        if ($tipo=="admin"){
            $cadena="select id as id_documento from documentos";
        }else{
            $cadena = "(select distinct permiso_doc.id_documento from permiso_doc inner join permisos on permiso_doc.id_subgrupo=permisos.subgrupo where permisos.usuario='" . $this->loggedIn('iduser') . "') union ( select permisos_documentos.id_documento from permisos_documentos where id_usuario='".$this->loggedIn('iduser')."') union (select id as id_documento from documentos where todos='SI')";
        }
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_archivos($menu, $submenu)
    {
        $cadena      = "select nombre from menu where id='" . $menu . "'";
        $query       = $this->db->query($cadena)->getResult();
        $nombre_menu = "";
        foreach ($query as $key) {
            $nombre_menu = $key->nombre;
        }
        $cadena   = "select id from submenu where nombre='" . $submenu . "'";
        $query    = $this->db->query($cadena)->getResult();
        $idsumenu = "";
        foreach ($query as $key) {
            $idsumenu = $key->id;
        }
        $cadena = "select nombre, id, descarga from documentos where menu='" . str_replace(' ', '%20', $nombre_menu) . "' and activo='SI' and submenu='" . $idsumenu . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function permisos_doc($documento){
        $cadena="select id_subgrupo from permiso_doc where id_documento='".$documento."'";
         $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function charge_all_document(){
        $cadena="select id, nombre from documentos";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function descarga_doc($documento){
        $cadena="select descarga from documentos where id='".$documento."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function elimina_archivo($documento){
        $cadena="select nombre from documentos where id='".$documento."'";
        $query  = $this->db->query($cadena)->getResult();
        foreach ($query as $key) {
            copy("archivos/".$key->nombre,"papelera/documentos/".$documento."-".$key->nombre);
            
            unlink('archivos/'.$key->nombre);
        }
        $cadena="delete from permiso_doc where id_documento='".$documento."'";
        $query  = $this->db->query($cadena);
        $cadena="delete from documentos where id='".$documento."'";
        $query  = $this->db->query($cadena);

    }
     public function elimina_archivo2($documento){
       
        $cadena="delete from permiso_doc where id_documento='".$documento."'";
        $query  = $this->db->query($cadena);
        $cadena="delete from documentos where id='".$documento."'";
        $query  = $this->db->query($cadena);

    }
    public function carga_documentos()
    {
        $cadena = "select documentos.id,documentos.fecha, documentos.rev, documentos.nombre, documentos.estatus, documentos.descarga, menu.nombre as menu, submenu.nombre as submenu, empresas.nombre as empresa, empresas.id as id_empresa from documentos right join menu on documentos.menu=menu.id inner join submenu on documentos.submenu=submenu.id inner join empresas on menu.empresa=empresas.id ";

        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function carga_permisos($usuario)
    {
        $cadena = "select menu.nombre from menu left join permisos on menu.grupo=permisos.grupo where permisos.usuario='" . $usuario . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function ruta1documento($id)
    {
        $cadena = "select nombre, empresa from menu where id='" . $id . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function ruta2documento($id)
    {
        $cadena = "select nombre from submenu where id='" . $id . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function extrae_submenus($menu)
    {
        $cadena = "SELECT distinct submenu.id, submenu.nombre FROM documentos inner join submenu on documentos.submenu = submenu.id inner join permiso_doc ON documentos.id = permiso_doc.id_documento where submenu.padre='" . $menu . "'";

        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function crea_submenu($data)
    {
        $cadena = "select id from submenu where nombre='" . $data['nombre'] . "' and padre='" . $data['menu'] . "'";
        $numero = $this->db->query($cadena)->getNumRows();
        if ($numero != 0) {
            return false;
        } else {
            $cadena = "insert into submenu (nombre, padre) values ('" . $data['nombre'] . "', '" . $data['menu'] . "')";
            $query  = $this->db->query($cadena);
            if (!empty($query)) {
                return $query;
            } else {
                return false;
            }
        }
    }
    public function busca_folio($folio){
        $cadena="select * from documentos where folio='".strtoupper($folio)."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

    public function crea_archivo($data)
    {
        $fecha=date("Y").date("m").date("d");
        if ($data["tipo"]=="F" or $data["tipo"]=="T" or  $data["tipo"]=="O"){
             $cadena       = "insert into documentos (nombre, menu, activo, descarga, submenu, estatus, tipo, departamento,folio, fecha, rev,todos) values ('" . $data['nombre'] . "', '" . $data['menu'] . "', 'NO', '" . $data['descarga'] . "', '" . $data['submenu'] . "','A', '".$data["tipo"]."','".$data["departamento"]."','".strtoupper($data["folio"])."','".$fecha."','".$data["revision"]."','".$data["todos"]."')";
        }else{
             $cadena       = "insert into documentos (nombre, menu, activo, descarga, submenu, estatus, tipo, departamento,folio, fecha, rev, todos) values ('" . $data['nombre'] . "', '" . $data['menu'] . "', 'NO', '" . $data['descarga'] . "', '" . $data['submenu'] . "','P', '".$data["tipo"]."','".$data["departamento"]."','".strtoupper($data["folio"])."','".$fecha."','".$data["revision"]."','".$data["todos"]."')";
        }
       
        $query        = $this->db->query($cadena);
        $cadena       = "select id from documentos where nombre='" . $data['nombre'] . "'";
        $query        = $this->db->query($cadena)->getResult();
        $id_documento = "";
        foreach ($query as $key) {
            $id_documento = $key->id;
        }
        
            foreach ($data['permisos'] as $permiso) {
                $cadena = "insert into permiso_doc (id_documento, id_subgrupo) values ('" . $id_documento . "', '" . $permiso . "')";
                $query  = $this->db->query($cadena);
            }
        
        
            foreach ($data["vali"] as  $validador) {
                $cadena="insert into verificacion (id_documento, id_usuario, estatus) values ('".$id_documento."', '".$validador."','P')";
                $query  = $this->db->query($cadena);
            }
    
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function modifica_archivo($data){
 

        $cadena="update documentos set nombre='".$data["re_nombre"]."', menu='".$data["menu"]."', descarga='".$data["descarga"]."', submenu='".$data["submenu"]."',tipo='".$data["tipo"]."', departamento='".$data["departamento"]."', folio='".$data["folio_doc"]."', rev='".$data["revision"]."', todos='".$data["todos"]."' where id='".$data["id"]."'";
        $query        = $this->db->query($cadena);

        
        $cadena="delete from permiso_doc where id_documento='".$data["id"]."'";
        $query        = $this->db->query($cadena);
         foreach ($data['permisos'] as $permiso) {
            $cadena = "insert into permiso_doc (id_documento, id_subgrupo) values ('" . $data["id"] . "', '" . $permiso . "')";
            $query  = $this->db->query($cadena);
        }
        //print_r($data["vali"]);
        //exit();
        /*$cadena="delete from verificacion where id_documento='".$data["id"]."'";
        $query  = $this->db->query($cadena);
        foreach ($data["vali"] as  $validador) {
                $cadena="insert into verificacion (id_documento, id_usuario, estatus) values ('".$data["id"]."', '".$validador."','P')";
                $query  = $this->db->query($cadena);
            }
            */
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_empresa_permiso($numero)
    {
        $cadena = "select distinct permisos.empresa, empresas.nombre from permisos inner join empresas on permisos.empresa=empresas.id where permisos.usuario='" . $numero . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function menu_de_empresa($empresa)
    {
        $cadena = "select nombre, id from menu where empresa='" . $empresa . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function extrae_permisos($usuario)
    {
        $cadena = "select menu.nombre, menu.id from menu left join permisos on menu.grupo=permisos.subgrupo where permisos.usuario='" . $usuario . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function grupo_permisos($usuario)
    {
        $cadena = "select distinct  grupos.nomber, grupos.id from grupos inner join permisos on grupos.id=permisos.grupo where permisos.usuario='" . $usuario . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function buscar_archivo_8d($solucion, $tipo){
        $cadena="select  id, archivo from archivos_8d where tipo_solucion='".$tipo."' and id_solucion='".$solucion."'";
          $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_archivo_8d($data){
       
        $cadena="insert into archivos_8d (tipo_solucion, id_solucion, archivo) values ('".$this->session->userdata('tipo_solucion')."','".$data["solucion"]."', '".$data["nombre_archivo"]."')";
        $query  = $this->db->query($cadena);
        //$this->session->unset_userdata('tipo_solucion');

        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }



    }
    public function extrae_solucion($solucion,$tipo){
        $cadena="select solucion from solucion_".$tipo.' where id_'.$tipo."='".$solucion."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }

    }
    public function general_junta($id){
        $cadena="select * from juntas where id_junta='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function archivos($usuario){
        $cadena="select proyecto.nombre_proyecto, subproyecto.nombre as subproyecto, usuario.nombre from proyecto inner join subproyecto on proyecto.id_proyecto=subproyecto.id_proyecto inner join usuario on subproyecto.id_usuario=usuario.id inner join archivos_proyectos on subproyecto.id_subproyecto=archivos_proyectos.id_subproyecto where subproyecto.terminado='NO'";
         $query = $this->db->query($cadena);

        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function visto($id){
        $cadena="insert into visto (documento, usuario) values ('".$id."', '".$this->loggedIn('iduser')."')";
        $query = $this->db->query($cadena);

        if (!empty($query)) {
            return "SI";
        } else {
            return "NO";
        }
    }
    public function visto2($id){
        $cadena="insert into visto_avisos (aviso, usuario) values ('".$id."', '".$this->loggedIn('iduser')."')";
         $query = $this->db->query($cadena);

        if (!empty($query)) {
            return "SI";
        } else {
            return "NO";
        }
    }
    public function nombre_archivo($id)
    {
        $cadena = "select nombre from documentos where id='" . $id . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function extrae_subgrupo($grupo, $usuario)
    {
        $cadena = "select subgrupos.id, subgrupos.nombre from subgrupos inner join permisos on subgrupos.id=permisos.subgrupo where permisos.grupo='" . $grupo . "' and permisos.usuario='" . $usuario . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function general_8d($id){
        $cadena="select * from analisis_8d where folio='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function carga_8d(){
        $cadena="select analisis_8d.folio, analisis_8d.fecha, analisis_8d.tipo,analisis_8d.problema_detectado, usuario.nombre from analisis_8d inner join usuario on analisis_8d.solicitante=usuario.id order by analisis_8d.folio";
        //$cadena="select folio, fecha, solicitante, tipo from analisis_8d order by folio";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function extrae_todo(){
        $cadena="select menu.nombre as menu, submenu.nombre as submenu , empresas.nombre as empresa, menu.id as id_menu, submenu.id as id_submenu from menu left join submenu on submenu.padre=menu.id inner join empresas on menu.empresa=empresas.id";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function extrae_menus2($dato)
    {
        $cadena = "select nombre ,id from menu where empresa='" . $dato . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function extrae_menus($dato)
    {
        $cadena = "select  menu.nombre as menu, menu.id as idmenu, grupos.nomber as grupo from menu inner join grupos on menu.grupo=grupos.id where menu.empresa='" . $dato . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function leer_empresas()
    {
        $cadena="select * from empresas";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function agrega_informado($data){
        $cadena="insert into informados (folio_proyecto, id_usuario) values ('".$data["id_tarea"]."', '".$data["usuario"]."')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function agrega_consultor($data){
        $cadena="insert into consultores (folio_proyecto, id_usuario) values ('".$data["id_tarea"]."', '".$data["usuario"]."')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_usuarios()
    {
        $cadena = "select * from usuario order by nombre asc";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_menus($numero)
    {
        $cadena = "select menu.nombre as menu, submenu.nombre as submenu, menu.id as idmenu, submenu.id as idsubmenu, menu.empresa as empresa from menu left join submenu on menu.id=submenu.padre where menu.empresa='" . $numero . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

    public function carga_submenu($menu)
    {
        $cadena = "select nombre, id from submenu where padre='" . $menu . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_todo()
    {
        $cadena = "select empresas.nombre, grupos.nomber as grupo,subgrupos.nombre as subgrupo, grupos.id   as idgrupo, subgrupos.id as idsubgrupos, empresas.id as idempresa from empresas left join grupos on empresas.id=grupos.empresa left join subgrupos on grupos.id=subgrupos.gupo";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function elimina_submenu($data)
    {
        $cadena = "delete from submenu where id='" . $data . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function modifica_usuario($data)
    {
        $cadena  = "update usuario set nombre='" . $data['nombre'] . "', pass='" . $data["pass"] . "', usuario='" . $data["usuario"] . "', tipo='" . $data["tipo"] . "', juntas='".$data["minutas"]."' where id='" . $data["id"] . "'";
        $query   = $this->db->query($cadena);
        $usuario = $data["id"];
        $cadena  = "delete from permisos where usuario='" . $data["id"] . "'";
        $query   = $this->db->query($cadena);
        foreach ($data['permisos'] as $permiso) {
            $tipo   = substr($permiso, 0, 1);
            $numero = intval(substr($permiso, 1, (strlen($permiso) - 1)));
            switch ($tipo) {
                case 'E':
                    if ($numero == "") {
                        $empresa = "0";
                    } else {
                        $empresa = $numero;
                    }
                    break;
                case 'G':
                    if ($numero == "") {
                        $grupo = "0";
                    } else {
                        $grupo = $numero;
                    }
                    break;
                case 'S':
                    $subgrupo = $numero;
                    $cadena   = "insert into permisos (usuario, empresa, grupo, subgrupo) values ('" . $usuario . "', '" . $empresa . "', '" . $grupo . "', '" . $subgrupo . "')";
                    $query    = $this->db->query($cadena);
                    $empresa  = "0";
                    $grupo    = "0";
                    $subgrupo = "0";
                    break;
            };
        };
        $cadena = "select subgrupo,id from permisos where grupo='0'";
        $query  = $this->db->query($cadena)->getResult();
        foreach ($query as $key) {
            $cadena2 = "select gupo from subgrupos where id='" . $key->subgrupo . "'";
            $query2  = $this->db->query($cadena2)->getResult();
            foreach ($query2 as $zas) {
                $cadena3 = "update permisos set grupo='" . $zas->gupo . "' where id='" . $key->id . "'";
                $this->db->query($cadena3);
            }
        }
        $cadena = "select grupo, id from permisos where empresa='0'";
        $query  = $this->db->query($cadena)->getResult();
        foreach ($query as $key) {
            $cadena2 = "select empresa from grupos where id='" . $key->grupo . "'";
            $query2  = $this->db->query($cadena2)->getResult();
            foreach ($query2 as $zas) {
                $cadena3 = "update permisos set empresa='" . $zas->empresa . "' where id='" . $key->id . "'";
                $this->db->query($cadena3);
            }
        }
        return true;
    }
    public function verfica_sala($data){
        $date = date_create($data["fecha"]);


        $fecha = date($data["fecha"]);
        $nuevafecha = strtotime ( '+'.$data["duracion"].' hour' , strtotime ( $fecha ) ) ;
       
        $nuevafecha = date ( 'H:i:s' , $nuevafecha );

        $cadena="select * from reservaciones where fecha='".date_format($date, 'Y-m-d')."' and sala='".$data["lugar"]."' and  hora between '".date_format($date, 'H:i:s')."' and '".$nuevafecha."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }

    }
    public function actualiza_perfil($data){
        $cadena="update usuario set nombre='".$data["nombre"]."', pass='".$data["pass"]."', usuario='".$data["usuario"]."', img='".$data["archivo"]."' where id='".$this->loggedIn('iduser')."'";

         $query  = $this->db->query($cadena);
        

    }
    public function notas_doc($id){
        $cadena="select mensaje from mensajes_doc where id_documento='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function activa_doc($id){
        $cadena="update  documentos set activo='SI', estatus='A' where id='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

    public function todo_documentos($documento){
        $cadena="select * from documentos where id='".$documento."'";

        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function documentos_pendientes(){
        $cadena="(select nombre, id, estatus, tipo, departamento from documentos where  activo='NO' and (estatus<>'P' or tipo='MP' or tipo='T' or tipo='I' or tipo='F' ))UNION (select documentos.nombre, documentos.id, verificacion.estatus , documentos.tipo, documentos.departamento from documentos inner join verificacion on documentos.id=verificacion.id_documento where verificacion.estatus='R')";
        
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

        public function read_user_information($username)
    {
        $query = $this->db->table('usuario')
            ->where('usuario', $username)
            ->limit(1)
            ->get();

        if ($query->getNumRows() === 1) {
            return $query->getResult();
        }

        return false;
    }
    public function carga_datos_usuario($numero)
    {
        $cadena = "select  * from usuario where id='" . $numero . "'";
        
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function elimina_menu($numero)
    {   
        $cadena="delete from submenu where padre='".$numero."'";
        $this->db->query($cadena);
        $cadena = "delete from menu where id='" . $numero . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function crea_menu($data)
    {
        $cadena = "select id from menu where nombre='" . $data["nombre"] . "'  and empresa='" . $data["empresa"] . "'";
        $numero = $this->db->query($cadena)->getNumRows();
        if ($numero != 0) {
            return false;
        } else {
            $cadena = "insert into menu (nombre, empresa) values ('" . $data["nombre"] . "', '" . $data["empresa"] . "')";
            $query  = $this->db->query($cadena);
            if (!empty($query)) {
                return $query;
            } else {
                return false;
            }
        }
    }
    public function leer_grupo($numero)
    {
        $cadena = "select nomber, id from grupos where empresa='" . $numero . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

    public function leer_subrupos($numero)
    {
        $cadena="select subgrupos.id, subgrupos.nombre, grupos.nomber from subgrupos inner join grupos on subgrupos.gupo=grupos.id where subgrupos.empresa='".$numero."'";
       
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function leer_subrupos2($numero,$grupo)
    {
        $cadena="select subgrupos.id, subgrupos.nombre, grupos.nomber from subgrupos inner join grupos on subgrupos.gupo=grupos.id where subgrupos.empresa='".$numero."' and subgrupos.gupo='".$grupo."'";;
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

    public function estructura_todo($empresa)
    {
        $cadena = "select empresas.nombre, empresas.id as idempresa, grupos.nomber as grupo,subgrupos.nombre as subgrupo, grupos.id as idgrupo, subgrupos.id as idsubgrupos from empresas LEFT join grupos on empresas.id=grupos.empresa LEFT join subgrupos on grupos.id=subgrupos.gupo where empresas.id='" . $empresa . "';";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function crea_empresa($data)
    {
        $cadena = "select id from empresas where nombre='" . $data["nombre"] . "'";
        $numero = $this->db->query($cadena)->getNumRows();
        if ($numero != 0) {
            return false;
        } else {
            $cadena = "insert into empresas (nombre, calle, numero_ext, numero_int, colonia, ciudad, estado, cp, rfc, apoderado, logo) values ('" . $data['nombre'] . "','" . $data['calle'] . "','" . $data['numero_ext'] . "','" . $data['numero_int'] . "','" . $data['colonia'] . "','" . $data['ciudad'] . "','" . $data['estado'] . "','" . $data['cp'] . "', '" . $data['rfc'] . "','" . $data['apoderado'] . "','" . $data['logo'] . "')";
            $query  = $this->db->query($cadena);
            if (!empty($query)) {
                return $query;
            } else {
                return false;
            }
        }
    }
    public function crea_grupo($data)
    {
        $cadena = "select id from grupos where nomber='" . $data["nombre"] . "' and empresa='" . $data["empresa"] . "'";
        $numero = $this->db->query($cadena)->getNumRows();
        if ($numero != 0) {
            return false;
        } else {
            $cadena = "insert into grupos (nomber, empresa) values ('" . $data["nombre"] . "', '" . $data['empresa'] . "')";
            $query  = $this->db->query($cadena);
            if (!empty($query)) {
                return $query;
            } else {
                return false;
            }
        }
    }
    public function unic_document($usuario){
        $cadena="select menu.nombre , documentos.menu, documentos.submenu, documentos.id from documentos inner join permisos_documentos on permisos_documentos.id_documento=documentos.id left join menu on documentos.menu=menu.id inner join submenu on documentos.submenu where permisos_documentos.id_usuario='".$usuario."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function empresa_usuario($usuario)
    {
        $cadena = "select distinct empresas.nombre, empresas.id from permisos left join empresas on permisos.empresa=empresas.id where permisos.usuario='" . $usuario . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function crea_subgrupo($dato)
    {
        $cadena = "select id from subgrupos where nombre='" . $dato['nombre'] . "' and gupo='" . $dato['grupo'] . "' and empresa='" . $dato['empresa'] . "'";
        $numero = $this->db->query($cadena)->getNumRows();
        if ($numero != 0) {
            return false;
        } else {
            $cadena = "insert into subgrupos (nombre, gupo, empresa) values ('" . $dato["nombre"] . "', '" . $dato['grupo'] . "','" . $dato['empresa'] . "')";
            $query  = $this->db->query($cadena);
            if (!empty($query)) {
                return $query;
            } else {
                return false;
            }
        }
    }
    public function video(){

        $tipo=$this->loggedIn('tipo');
        if ($tipo=="admin"){
            $cadena="select * from documentos where tipo='T'";
        }else{
            $juntas=$this->loggedIn('juntas');
            $reportes=$this->loggedIn('reportes');

        }

        $cadena="select * from documentos where tipo='T'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
        
    }
    public function extrea_menu_usuario($usuario, $empresa)
    {
        $cadena="select DISTINCT menu.id, menu.nombre as menu from documentos inner join menu on documentos.menu=menu.id where menu.empresa='".$empresa."' and documentos.id in (select documentos.id from documentos inner join permisos on documentos.menu=permisos.grupo where permisos.usuario='".$usuario."')";
    
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function elimina_gropo($numero)
    {
        $cadena = "delete from grupos where id='" . $numero . "'";
        $query  = $this->db->query($cadena);
        $cadena = "delete from subgrupos where gupo='" . $numero . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function elimina_subgrupo($numero)
    {
        $cadena = "delete from subgrupos where id='" . $numero . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function crea_usuario($data)
    {

        $cadena = "insert into usuario (nombre, pass, usuario, tipo, juntas) values ('" . $data['nombre'] . "', '" . $data['pass'] . "', '" . $data['usuario'] . "','" . $data['tipo'] . "', '".$data["minutas"]."')";
        $query  = $this->db->query($cadena);
        if ($data['tipo'] == "empr") {
            $cadena    = "select id from usuario where nombre='" . $data['nombre'] . "' and pass='" . $data['pass'] . "'";
            $query     = $this->db->query($cadena);
            $idusuario = "";
            foreach ($query->getResult() as $usuario) {
                $idusuario = $usuario->id;
            }
            $empresa  = "0";
            $grupo    = "0";
            $subgrupo = "0";

            foreach ($data['permisos'] as $permiso) {
                $tipo   = substr($permiso, 0, 1);
                $numero = intval(substr($permiso, 1, (strlen($permiso) - 1)));
                switch ($tipo) {
                    case 'E':
                        $empresa = $numero;
                        break;
                    case 'G':
                        $grupo = $numero;
                        break;
                    case 'S':
                        $subgrupo = $numero;
                        $cadena   = "insert into permisos (usuario, empresa, grupo, subgrupo) values ('" . $idusuario . "', '" . $empresa . "', '" . $grupo . "', '" . $subgrupo . "')";
                        $query    = $this->db->query($cadena);
                        $empresa  = "0";
                        $grupo    = "0";
                        $subgrupo = "0";
                        break;
                };
            };
            $cadena = "select subgrupo,id from permisos where grupo='0'";
            $query  = $this->db->query($cadena)->getResult();
            foreach ($query as $key) {
                $cadena2 = "select gupo from subgrupos where id='" . $key->subgrupo . "'";
                $query2  = $this->db->query($cadena2)->getResult();
                foreach ($query2 as $zas) {
                    $cadena3 = "update permisos set grupo='" . $zas->gupo . "' where id='" . $key->id . "'";
                    $this->db->query($cadena3);
                }
            }
            $cadena = "select grupo, id from permisos where empresa='0'";
            $query  = $this->db->query($cadena)->getResult();
            foreach ($query as $key) {
                $cadena2 = "select empresa from grupos where id='" . $key->grupo . "'";
                $query2  = $this->db->query($cadena2)->getResult();
                foreach ($query2 as $zas) {
                    $cadena3 = "update permisos set empresa='" . $zas->empresa . "' where id='" . $key->id . "'";
                    $this->db->query($cadena3);
                }
            }
        }
    }
    public function pendientes_revicion(){
        $cadena="select documentos.id, documentos.nombre, documentos.departamento, documentos.tipo, verificacion.estatus from documentos inner join verificacion on verificacion.id_documento=documentos.id where verificacion.estatus='P' and verificacion.id_usuario='".$this->loggedIn('iduser')."' ";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function lee_juntas()
    {
        if ($this->loggedIn('tipo')=="admin"){
            $cadena = "select id_junta, fecha, tema, lugar,  duracion, impartidor, creador, activo, asignada from juntas where activo='SI'";
        }else{
            /*if ($this->loggedIn('juntas')=="SI"){
                $cadena = "select  id_junta, fecha, tema, lugar,  duracion, impartidor, creador, activo, asignada from juntas  where activo='SI' and (impartidor='".$this->loggedIn('iduser')."' or creador='".$this->loggedIn('iduser')."')";
            }else{*/
                $cadena="select * from juntas where creador='".$this->loggedIn('iduser')."' or impartidor='".$this->loggedIn('iduser')."'";
                 $query  = $this->db->query($cadena);
                 if ($query->getNumRows()==0){
                     $cadena = "select  DISTINCT  juntas.id_junta, juntas.fecha, juntas.tema, juntas.lugar,  juntas.duracion, juntas.impartidor, juntas.creador, juntas.activo, juntas.asignada from juntas inner join integrantes on  juntas.id_junta=integrantes.id_junta where juntas.activo='SI' and (juntas.impartidor='".$this->loggedIn('iduser')."' or juntas.creador='".$this->loggedIn('iduser')."' or integrantes.id_usuario='".$this->loggedIn("iduser")."')";
                 }else{
                     $cadena = "select  DISTINCT  juntas.id_junta, juntas.fecha, juntas.tema, juntas.lugar,  juntas.duracion, juntas.impartidor, juntas.creador, juntas.activo, juntas.asignada from juntas  where juntas.activo='SI' and (juntas.impartidor='".$this->loggedIn('iduser')."' or juntas.creador='".$this->loggedIn('iduser')."')";
                 }
               
            /*}*/
            
        }

        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function lee_juntas2()
    {
       
        $cadena = "select * from juntas where asignada='NO' and creador='".$this->loggedIn('iduser')."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function extre_impartidor($numero)
    {
        $cadena = "select nombre from usuario where id='" . $numero . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function agrega_tema($datos)
    {
        $cadena = "insert into temas_juntas (tema, archivo) values ('" . $datos["tema"] . "','SI')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function list_sin_guardar()
    {
        $cadena = "select tema, id_tema from temas_juntas where id_junta is NULL";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function elimina_tema($dato)
    {
        $cadena = "delete from temas_juntas where id_tema='" . $dato['numero'] . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function combocados()
    {
        $cadena = "select usuario.nombre, integrantes.id_integrante from integrantes left join usuario on integrantes.id_usuario=usuario.id where integrantes.id_junta is NULL";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function agrega_combocado($data)
    {
        $cadena = "insert into integrantes (id_usuario) values ('" . $data["usuario"] . "')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function elimina_integrante($data)
    {
        $cadena = "delete from integrantes where id_integrante='" . $data['integrante'] . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function guardar_junta($data)
    {
       

    
        
        $cadena = "insert into juntas (tema, fecha, duracion, lugar, impartidor, asignada, tipo, vueltas, marcada,creador, activo) values ('" . $data['tema'] . "','" . $data["fecha"] . "', '".$data["duracion"]."', '" . $data['lugar'] . "','" . $data['impartidor'] . "','NO','".$data["tipo"]."','0','NO', '".$this->loggedIn('iduser')."','SI')";

        $query    = $this->db->query($cadena);
       

       



        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function tema_junta($junta)
    {
        $cadena = "select id_tema, tema from temas_juntas where id_junta='" . $junta . "' ";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
     public function temas_junta($junta)
    {
        $cadena = "select * from temas_juntas where id_junta='" . $junta . "' ";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function reporte_8d($fecha,$tipo){
        if ($tipo=="todos"){
            $cadena="select analisis_8d.folio, analisis_8d.id_8d, analisis_8d.problema_detectado, solucion_temporal.solucion,usuario.nombre as usuario, solucion_temporal.f_fin from analisis_8d inner join solucion_temporal on solucion_temporal.folio_8d=analisis_8d.folio inner join usuario on solucion_temporal.id_responsable=usuario.id where solucion_temporal.activo='SI'";
        }else{
            $cadena="select analisis_8d.folio, analisis_8d.id_8d, analisis_8d.problema_detectado, solucion_temporal.solucion,usuario.nombre as usuario, solucion_temporal.f_fin from analisis_8d inner join solucion_temporal on solucion_temporal.folio_8d=analisis_8d.folio inner join usuario on solucion_temporal.id_responsable=usuario.id where solucion_temporal.activo='SI' and solucion_temporal.id_responsable='".$tipo."'";
        }
        
         $query  = $this->db->query($cadena);
        
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function participantes_junta($junta)
    {
        $cadena = "select usuario.id, usuario.nombre, integrantes.asistencia from integrantes left join usuario on integrantes.id_usuario=usuario.id where integrantes.id_junta='" . $junta . "'";
        
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function reactivar_minuta($junta){
        $cadena="update juntas set activo='SI' where id_junta='".$junta."'";
        $this->db->query($cadena);
        $cadena="update temas_juntas set activo='SI' where id_junta='".$junta."'";
        $this->db->query($cadena);  
    }
    public function cuenta_mensajes($id){
        $cadena="select * from chat where leido='NO' and envia='".$id."' and usuario='".$this->loggedIn('iduser')."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function lee_junta($junta){
        $cadena = "select * from juntas where id_junta='" . $junta . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function guardar_evento($data){
        if ($data["f_inicio"]==$data["f_fin"]){
            $nuevafecha=$data["f_fin"];
        }else{
            $fecha = $data["f_fin"];
            $nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
            $nuevafecha = date ( 'Y-m-j' , $nuevafecha );
        }
       
        $cadena="insert into eventos (titulo, fecha_inicio, fecha_fin, activo, tipo, descripcion) values ('".$data["titulo"]."', '".$data["f_inicio"]."', '".$nuevafecha."', 'SI', '".$data["tipo"]."', '".$data["descripcion"]."')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }

    }
    public function det_junta($junta)
    {
        if ($this->loggedIn('tipo')=="admin"){
            $cadena = "select temas_juntas.id_tema ,usuario.nombre, temas_juntas.tema, temas_juntas.fecha_compromiso, temas_juntas.terminado from temas_juntas left join usuario on temas_juntas.id_usuario_encargado=usuario.id where temas_juntas.id_junta='" . $junta . "'";
        }else{
            $cadena="select impartidor,creador from juntas where id_junta='".$junta."'";
            $query  = $this->db->query($cadena)->getResult();
            if ($query[0]->impartidor==$this->loggedIn('iduser') or $query[0]->creador==$this->loggedIn('iduser')){
                $cadena = "select temas_juntas.id_tema ,usuario.nombre, temas_juntas.tema, temas_juntas.fecha_compromiso, temas_juntas.terminado from temas_juntas left join usuario on temas_juntas.id_usuario_encargado=usuario.id where temas_juntas.id_junta='" . $junta . "'";
            }else{
                $cadena="select asistencia from integrantes where id_junta='".$junta."' and id_usuario='".$this->loggedIn('iduser')."'";
            
                $query  = $this->db->query($cadena)->getResult();
                
                if ($query[0]->asistencia=="SI"){
                     $cadena = "select temas_juntas.id_tema ,usuario.nombre, temas_juntas.tema, temas_juntas.fecha_compromiso, temas_juntas.terminado from temas_juntas left join usuario on temas_juntas.id_usuario_encargado=usuario.id where temas_juntas.id_junta='" . $junta . "'";
                }else{
                     $cadena = "select temas_juntas.id_tema ,usuario.nombre, temas_juntas.tema, temas_juntas.fecha_compromiso, temas_juntas.terminado from temas_juntas left join usuario on temas_juntas.id_usuario_encargado=usuario.id where temas_juntas.id_junta='" . $junta . "' and   temas_juntas.id_usuario_encargado='".$this->loggedIn('iduser')."'";
                }   
            }
            
        }
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function solucion_reagendar($data){
        $cadena="update reagendar set respuesta='".$data["solucion"]."' where id_reagenda='".$data["id"]."'";
        $query  = $this->db->query($cadena);
        $cadena="select subproyecto from reagendar where id_reagenda='".$data["id"]."'";
        $query  = $this->db->query($cadena)->getResult();
        $cadena="select reagenda from subproyecto where id_subproyecto='".$query[0]->subproyecto."'";
        $subproyecto=$query[0]->subproyecto;
        $query  = $this->db->query($cadena)->getResult();
        $cadena="update subproyecto set reagenda='".(($query[0]->reagenda)+1)."' where id_subproyecto='".$subproyecto."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function atender_reagendar($id){
        $cadena="update reagendar set visto='SI' where id_reagenda='".$id."' ";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function repuesta_reagendar(){
         $cadena="select reagendar.respuesta,reagendar.id_reagenda,subproyecto.nombre as subproyecto, proyecto.nombre_proyecto from reagendar inner join subproyecto on reagendar.subproyecto=subproyecto.id_subproyecto inner join proyecto on reagendar.proyecto=proyecto.id_proyecto where  reagendar.visto='NO'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function terminar_agenda($id){
        $cadena="updaste pendientes set activo='NO' where id_pendiente='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function pendientes_agenda(){
        $cadena="select titulo,fecha, id_pendiente from pendientes where usuario='".$this->loggedIn('iduser')."' and fecha<= DATE_ADD(CURDATE(), INTERVAL 3 DAY) AND activo='SI' ";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function pendientes_ragendar(){
        $cadena="select reagendar.id_reagenda,subproyecto.nombre as subproyecto, proyecto.nombre_proyecto from reagendar inner join subproyecto on reagendar.subproyecto=subproyecto.id_subproyecto inner join proyecto on reagendar.proyecto=proyecto.id_proyecto where reagendar.capitan='".$this->loggedIn('iduser')."' and reagendar.respuesta=''";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function eliminar_evento($id){
        $cadena="delete from pendientes where id_pendiente='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_agenda($id){
        $cadena="select id_pendiente, titulo, fecha, f_fin from pendientes where activo='SI' and usuario='".$id."'";

        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function notas_reagendar($id){
        $cadena="select notas from reagendar where id_reagenda='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function agregar_agenda($data){
        $cadena="insert into pendientes (usuario, tema, fecha, activo, f_fin, titulo) values ('".$this->loggedIn('iduser')."', '' ,'".$data["inicio"]."', 'SI', '".$data["fin"]."','".$data["titulo"]."')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function pedir_reagendar($data){
        $cadena="select capitan from proyecto where id_proyecto='".$data["proyecto"]."'";
        $query  = $this->db->query($cadena)->getResult();
        $cadena="insert into reagendar (proyecto, subproyecto, capitan, notas) values ('".$data["proyecto"]."','".$data["subproyecto"]."', '".$query[0]->capitan."','".$data["notas"]."')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function ver_archivo($id_tema)
    {
        $cadena = "select * from archivos_juntas where id_tema='" . $id_tema . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function impartidor($junta)
    {
        $cadena = "select usuario.nombre from juntas inner join usuario on juntas.impartidor=usuario.id where juntas.id_junta='" . $junta . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }

    public function soluciones_8d($usuario){
        $cadena="select solucion, id_permanente from solucion_permanente where id_responsable='".$usuario."' and activo='NO'";
        $query  = $this->db->query($cadena)->getResult();

        $data=[];


        foreach ($query as $key) {
            array_push($data, array($key->id_permanente,$key->solucion, 'permanente'));
        }
        $cadena="select solucion, id_preventivo from solucion_preventivo where id_responsable='".$usuario."' and activo='NO'";
        $query  = $this->db->query($cadena)->getResult();
        
        foreach ($query as $key) {
            array_push($data, array($key->id_preventivo,$key->solucion, 'preventivo'));
        }
        $cadena="select solucion, id_temporal from solucion_temporal where id_responsable='".$usuario."' and activo='NO'";
        $query  = $this->db->query($cadena)->getResult();
        foreach ($query as $key) {
            array_push($data, array($key->id_temporal,$key->solucion, 'temporal'));
        }
        
        
        return $data;
    }
    public function pendientes_8d($usuario){
        $cadena="select solucion, id_permanente from solucion_permanente where id_responsable='".$usuario."' and activo='SI'";
        $query  = $this->db->query($cadena)->getResult();

        $data=[];


        foreach ($query as $key) {
            array_push($data, array($key->id_permanente,$key->solucion, 'permanente'));
        }
        $cadena="select solucion, id_preventivo from solucion_preventivo where id_responsable='".$usuario."' and activo='SI'";
        $query  = $this->db->query($cadena)->getResult();
        
        foreach ($query as $key) {
            array_push($data, array($key->id_preventivo,$key->solucion, 'preventivo'));
        }
        $cadena="select solucion, id_temporal from solucion_temporal where id_responsable='".$usuario."' and activo='SI'";
        $query  = $this->db->query($cadena)->getResult();
        foreach ($query as $key) {
            array_push($data, array($key->id_temporal,$key->solucion, 'temporal'));
        }
        
        
        return $data;
    }
    public function pendientes_juntas($id_usuario)
    {
        
        $cadena="select temas_juntas.id_tema, temas_juntas.tema, juntas.tema as junta, temas_juntas.fecha_compromiso, temas_juntas.archivo from temas_juntas inner join juntas on temas_juntas.id_junta=juntas.id_junta where  temas_juntas.terminado='NO' and temas_juntas.activo='SI' and temas_juntas.id_usuario_encargado='" . $id_usuario . "'";
       
        $query      = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function leer_tema_junta($id_tema)
    {
        $cadena = "select * from temas_juntas where id_tema='" . $id_tema . "'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function juntas_proximas($usuario)
    {
        $dia_actual = date('Y-m-d');
        $fecha1     = strtotime($dia_actual . "+ 3 days");
        $cadena     = "select juntas.id_junta, juntas.tema, juntas.fecha, juntas.tipo, juntas.vueltas, juntas.lugar from juntas right join integrantes on juntas.id_junta=integrantes.id_junta where juntas.fecha>='" . $dia_actual . "' and juntas.fecha<='" . date("Y-m-d", $fecha1) . "' and integrantes.id_usuario='" . $usuario . "'";
         $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
   
    public function lista_proyectos2($usuario){
         $cadena="select distinct proyecto.nombre_proyecto, proyecto.f_fin, proyecto.capitan, proyecto.subcapitan, proyecto.f_inicio, proyecto.id_proyecto from subproyecto inner join proyecto on subproyecto.id_proyecto=proyecto.id_proyecto left join consultores on consultores.folio_proyecto=subproyecto.id_subproyecto left join informados on informados.folio_proyecto=subproyecto.id_subproyecto where (subproyecto.id_usuario='".$usuario."'or subproyecto.responsable='".$usuario."' or proyecto.capitan='".$usuario."' or proyecto.subcapitan='".$usuario."' or consultores.id_usuario='".$usuario."' or informados.id_usuario='".$usuario."') and subproyecto.terminado='NO' ";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function empresa_8d($usuario){
       $cadena="select analisis_8d.folio, analisis_8d.fecha, analisis_8d.tipo,analisis_8d.problema_detectado, usuario.nombre from analisis_8d inner join usuario on analisis_8d.solicitante=usuario.id where analisis_8d.solicitante='".$usuario."' order by analisis_8d.folio";
        //$cadena="select folio, fecha, solicitante, tipo from analisis_8d order by folio";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function lista_proyectos()
    {
        $cadena = "select * from proyecto";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function guarda__mod_proyecto($data){

        $cadena="update proyecto set nombre_proyecto='".$data["proyecto"]."', capitan='".$data["capitan"]."', subcapitan='".$data["subcapitan"]."', f_inicio='".$data["finicio"]."', patrocinador='".$data["Patrocinador"]."' where id_proyecto='".$data["id"]."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function guarda_proyecto($data)
    {
        $cadena = "insert into proyecto (nombre_proyecto, capitan, subcapitan, f_inicio,patrocinador, pendiente) values ('" . $data['proyecto'] . "','" . $data['capitan'] . "', '" . $data['subcapitan'] . "', '" . $data['finicio'] . "','".$data["Patrocinador"]."','SI')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_proyectos_sin_tarea()
    {
        $cadena = "select id_proyecto, nombre_proyecto from proyecto where f_fin is NULL";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function proyectos_sin_asignar($proyecto)
    {
        $cadena="select subproyecto.id_subproyecto, subproyecto.nombre, subproyecto.responsable,usuario.nombre as persona, subproyecto.f_inicio, subproyecto.f_fin from subproyecto left join usuario on subproyecto.id_usuario=usuario.id where subproyecto.id_proyecto='".$proyecto."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function guarda_tarea($data)
    {   
        $cadena="insert into subproyecto (nombre, id_usuario,f_fin, f_inicio, id_proyecto,terminado,responsable) values ('".$data['nombre_tarea']."', '".$data["usuario_tarea"]."', '".$data["f_fin"]."', '".$data["f_inicio"]."', '".$data["proyecto"]."', 'NO','".$data["responsable"]."')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function elimina_tarea($idtarea)
    {
        $cadena="delete from subproyecto where id_subproyecto='".$idtarea."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function guardar_tarea($data)
    {
        $cadena="update subproyecto set id_proyecto='".$data["proyecto"]."' where id_proyecto='0'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function por_vencer(){
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '+3 days' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );

        $cadena="select subproyecto.id_subproyecto, subproyecto.id_proyecto as proyecto,subproyecto.nombre, subproyecto.f_inicio, subproyecto.f_fin, proyecto.nombre_proyecto from subproyecto inner join proyecto on subproyecto.id_proyecto=proyecto.id_proyecto where subproyecto.terminado='NO' and subproyecto.f_fin<='".$nuevafecha."'";

         $query      = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function pendintes_proyecto($usuario)
    {
        $cadena="select subproyecto.id_subproyecto, subproyecto.id_proyecto as proyecto,subproyecto.nombre, subproyecto.f_inicio, subproyecto.f_fin, proyecto.nombre_proyecto from subproyecto inner join proyecto on subproyecto.id_proyecto=proyecto.id_proyecto where subproyecto.id_usuario='".$usuario."' and subproyecto.terminado='NO'";
      

        
         $query      = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function pendintes_proyecto2($usuario)
    {
        $cadena="select subproyecto.id_subproyecto, subproyecto.id_proyecto as proyecto,subproyecto.nombre, subproyecto.f_inicio, subproyecto.f_fin, proyecto.nombre_proyecto from subproyecto inner join proyecto on subproyecto.id_proyecto=proyecto.id_proyecto where subproyecto.id_usuario='".$usuario."' or proyecto.capitan='".$usuario."' or proyecto.subcapitan='".$usuario."' and subproyecto.terminado='NO'";
        print_r($cadena);
        
        
         $query      = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function fechas_proyecto($data)
    {
        $cadena="select f_inicio, f_fin from proyecto where id_proyecto='".$data."'";
        $query  = $this->db->query($cadena)->getResult();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function eliminar_proyecto($proyecto){
        $cadena="delete from subproyecto where id_proyecto='".$proyecto."'";
        $this->db->query($cadena);
        $cadena="delete from proyecto where id_proyecto='".$proyecto."'";
        $this->db->query($cadena);
    }
    public function terminar_subproyecto($subproyecto){
        $cadena="UPDATE subproyecto set terminado='SI' where id_subproyecto='".$subproyecto."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function configuracion(){
        $cadena="select * from configuracion";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function lista_consultado($folio){
         $cadena="select usuario.nombre, consultores.id_consultor from consultores inner join usuario on consultores.id_usuario=usuario.id where consultores.folio_proyecto='".$folio."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function elimina_consultado($id){
        $cadena="delete from consultores where id_consultor='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function elimina_informador($id){
        $cadena="delete from informados where id_informado='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function lista_informado($folio){
        $cadena="select usuario.nombre, informados.id_informado from informados inner join usuario on informados.id_usuario=usuario.id where informados.folio_proyecto='".$folio."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function nombre_proyecto($id_proyecto)
    {
        $cadena="select * from proyecto where id_proyecto='".$id_proyecto."'";

        $query  = $this->db->query($cadena)->getResult();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function alerta_documento(){
        $fecha_actual = date("d-m-Y");
        $fecha_buca=date("Ymd",strtotime($fecha_actual."- 1 week"));
        $cadena = "(
        select distinct permiso_doc.id_documento    from permiso_doc inner join permisos on permiso_doc.id_subgrupo=permisos.subgrupo inner join documentos on permiso_doc.id_documento=documentos.id   where permiso_doc.id_documento not in (select documento as id_documento from visto where usuario='".$this->loggedIn("iduser")."') and permisos.usuario='" . $this->loggedIn('iduser') . "' and documentos.fecha>='".$fecha_buca."' and documentos.estatus='A') union ( 
        select permisos_documentos.id_documento     from permisos_documentos                                                                                                                            where id_usuario='".$this->loggedIn('iduser')."' and  permisos_documentos.id_documento not in (select documento as id_documento from visto where usuario='".$this->loggedIn("iduser")."')) union (
        select id as id_documento                   from documentos                                                                                                                                     where todos='SI' and estatus='A' and fecha>='".$fecha_buca."' and id not in (select documento as id from visto where usuario='".$this->loggedIn("iduser")."'))";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }

    }
    public function alerta_raci(){
        $cadena="(select proyecto.nombre_proyecto as proyecto, proyecto.id_proyecto, subproyecto.nombre as subproyecto , 'R' as tipo from proyecto inner join subproyecto on proyecto.id_proyecto=subproyecto.id_proyecto where subproyecto.id_usuario='".$this->loggedIn('iduser')."' and subproyecto.terminado='NO' and proyecto.f_fin is NULL) UNION (select proyecto.nombre_proyecto as proyecto, proyecto.id_proyecto, subproyecto.nombre as subproyecto , 'A' as tipo from proyecto inner join subproyecto on proyecto.id_proyecto=subproyecto.id_proyecto where subproyecto.responsable='".$this->loggedIn('iduser')."' and subproyecto.terminado='NO' and proyecto.f_fin is NULL) UNION (select proyecto.nombre_proyecto as proyecto, proyecto.id_proyecto, subproyecto.nombre as subproyecto, 'C' as tipo from proyecto inner join subproyecto on proyecto.id_proyecto=subproyecto.id_proyecto inner join consultores on subproyecto.id_subproyecto=consultores.folio_proyecto where consultores.id_usuario='".$this->loggedIn('iduser')."' and proyecto.f_fin is NULL) UNION (select proyecto.nombre_proyecto as proyecto, proyecto.id_proyecto, subproyecto.nombre as subproyecto, 'I' as tipo from proyecto inner join subproyecto on proyecto.id_proyecto=subproyecto.id_proyecto inner join informados on subproyecto.id_subproyecto=informados.folio_proyecto where informados.id_usuario='".$this->loggedIn('iduser')."' and proyecto.f_fin is NULL)";
       
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function raci($num){
        $cadena="select usuario.nombre as usuario, subproyecto.id_usuario as encargado, subproyecto.responsable, subproyecto.nombre, subproyecto.id_subproyecto from subproyecto inner join usuario on subproyecto.id_usuario=usuario.id where subproyecto.id_proyecto='".$num."'";
        $query  = $this->db->query($cadena)->getResult();
        //$data=array();
        foreach ($query as $key) {
            $data[$key->nombre]=array("R-".$key->usuario);
            $cadena2="select nombre from usuario where id='".$key->responsable."'";
            $query2  = $this->db->query($cadena2)->getResult();
            foreach ($query2 as $far) {
                array_push($data[$key->nombre],"A-".$far->nombre);
                //$data[$key->nombre]=array("C-".$far->usuario);
            }
            $cadena2="select usuario.nombre as usuario from consultores inner join usuario on consultores.id_usuario=usuario.id where consultores.folio_proyecto='".$key->id_subproyecto."'";
            $query2  = $this->db->query($cadena2)->getResult();
            foreach ($query2 as $far) {
                array_push($data[$key->nombre],"C-".$far->usuario);
                //$data[$key->nombre]=array("C-".$far->usuario);
            }
            $cadena2="select usuario.nombre as usuario from informados inner join usuario on informados.id_usuario=usuario.id where informados.folio_proyecto='".$key->id_subproyecto."'";
            $query2  = $this->db->query($cadena2)->getResult();
            foreach ($query2 as $far) {
                array_push($data[$key->nombre],"I-".$far->usuario);
                //$data[$key->nombre]=array("C-".$far->usuario);
            }
        }

        return $data;
    }

   
    public function  detalles_proyecto($id_proyecto)
    {
        $cadena="select subproyecto.id_subproyecto, subproyecto.nombre as tarea, subproyecto.f_inicio, subproyecto.f_fin, usuario.nombre,subproyecto.terminado, subproyecto.responsable,subproyecto.terminado from subproyecto left join usuario on subproyecto.id_usuario=usuario.id where subproyecto.id_proyecto='".$id_proyecto."'";
        
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function guarda_notas2($data){
        $cadena="insert into notas_proyectos (nota, fecha, id_subproyecto) values ('".$data["nota"]."', CURDATE(), '".$data["subproyecto"]."')";
        $query  = $this->db->query($cadena);
    }
    public function actualiza_subproyecto($data){
        $cadena="update subproyecto set nombre='".$data["nombre_tarea"]."', id_usuario='".$data["usuario_tarea"]."', f_inicio='".$data["f_inicio"]."', f_fin='".$data["f_fin"]."', responsable='".$data["responsable"]."' where id_subproyecto='".$data["id"]."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function subproyecto($id_subproyecto)
    {
        $cadena="select * from subproyecto where id_subproyecto='".$id_subproyecto."'";
        $query  = $this->db->query($cadena)->getResult();
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function limpiar_archivo_proyecto($subproyecto){
        $cadena="delete from archivos_proyectos where id_subproyecto='".$subproyecto."'";
         $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function buscar_archivos_proyectos($data){
        $cadena="select * from archivos_proyectos where id_subproyecto='".$data."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function carga_archivo_proyectos($data)
    {
        $cadena = "insert into archivos_proyectos (id_subproyecto, archivo) values ('" . $data['id_subproyecto'] . "','" . $data["nombre_archivo"] . "')";

        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function guarda_actividad($data){
        $cadena="insert into temas_juntas (id_junta, tema, fecha_compromiso, id_usuario_encargado, archivo, terminado) values ('".$this->session->id_minuta['id_minuta']."', '".$data["actividad"]."', '".$data["fecha"]."', '".$data["participante"]."','".$data["archivo"]."','NO')";
    
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            print_r("Guardado Exitosmente");
        } else {
            return false;
        }
    }
    public function termina_actividad($data){
        $cadena="update temas_juntas set terminado='SI' where id_tema='".$data["id_actividad"]."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function buscar_archivo($idtema){
        $cadena="select archivo from archivos_juntas where id_tema='".$idtema."'";
         $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function limpiar_archivo($data){
        $cadena="select archivo from archivos_juntas where id_tema='".$data["id_actividad"]."'";
        $query  = $this->db->query($cadena)->getResult();
        foreach ($query as $key) {
            $archivo="archivos_juntas/".$key->archivo;
            
            unlink($archivo);
        }
       

        $cadena="delete from archivos_juntas where id_tema='".$data["id_actividad"]."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function elimina_actividad($data){
        $cadena="delete from archivos_juntas where id_tema='".$data["id_actividad"]."'";
        $query  = $this->db->query($cadena);
        $cadena="delete from temas_juntas where id_tema='".$data["id_actividad"]."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function reagendar($data){
        $cadena="update temas_juntas set fecha_compromiso='".$data["fecha"]."' where id_tema='".$data["id_actividad"]."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        } 
    }
    public function termina_minuta($data){
        $cadena="update temas_juntas set terminado='SI' where id_junta='".$data['junta']."'";
        $query  = $this->db->query($cadena);
        $cadena="update juntas set asignada='SI' where id_junta='".$data['junta']."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        } 
    }
    public function leer_actividad($actividad){
        $cadena="select * from temas_juntas where id_tema='".$actividad."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        } 
    }
    public function guarda_modificado($data){
        $cadena="update temas_juntas set tema='".$data["actividad"]."', fecha_compromiso='".$data["fecha"]."', id_usuario_encargado='".$data["participante"]."', archivo='".$data["archivo"]."' where id_tema='".$data['tema']."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        } 
    }
    public function elimina_minuta($data){
        $cadena="delete from temas_juntas where id_junta='".$data["id_minuta"]."'";
       
        $query  = $this->db->query($cadena);
        $cadena="delete from juntas where id_junta='".$data["id_minuta"]."'";

        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        } 
    }
    public function info_correo($id){
        $cadena="select nombre, usuario, pass, correo from usuario where id='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        } 
    }
    public function reactiva_juntas(){
        $cadena="select * from juntas where asignada='SI' and marcada='NO'";
        $query  = $this->db->query($cadena)->getResult();

        $year=date("Y");
        $month=date("m");
        $day=date("d");
        $semana=date("W",mktime(0,0,0,$month,$day,$year));
 
        # Obtenemos el día de la semana de la fecha dada
        $diaSemana=date("w",mktime(0,0,0,$month,$day,$year));
         
        # el 0 equivale al domingo...
        if($diaSemana==0)
            $diaSemana=7;
         
        # A la fecha recibida, le restamos el dia de la semana y obtendremos el lunes
        $primerDia=date("d-m-Y",mktime(0,0,0,$month,$day-$diaSemana,$year));
         
        # A la fecha recibida, le sumamos el dia de la semana menos siete y obtendremos el domingo
        $ultimoDia=date("d-m-Y",mktime(0,0,0,$month,$day+(6-$diaSemana),$year));
        
        
        $id="";

        foreach ($query as $key) {
            $fecha=date("d-m-Y",strtotime($key->fecha));
            if ($fecha>$primerDia and $fecha<$ultimoDia){
                $id="";
            }else{
                if ($key->tipo=="s"){
                    $fecha_nueva=strtotime($fecha . "+ 1 week");
                    if ($fecha_nueva>$ultimoDia){

                        $cadena="insert into juntas (tema, fecha, duracion, lugar, impartidor, asignada, tipo, vueltas) values ('".$key->tema."', '".date ( 'Y-m-d' , $fecha_nueva ) ."', '".$key->duracion."', '".$key->lugar."', '".$key->impartidor."','NO','".$key->tipo."', '0')";
                        $this->db->query($cadena);
                        $id=$key->id_junta;
                        $cadena="update juntas set marcada='SI' where id_junta='".$id."' ";
                         $this->db->query($cadena);
                    }
                }
                if ($key->tipo=="m"){
                    $fecha_nueva=strtotime($fecha . "+ 1 month");
                    if ($fecha_nueva>$ultimoDia){

                        $cadena="insert into juntas (tema, fecha, duracion, lugar, impartidor, asignada, tipo, vueltas) values ('".$key->tema."', '".date ( 'Y-m-d' , $fecha_nueva ) ."', '".$key->duracion."', '".$key->lugar."', '".$key->impartidor."','NO','".$key->tipo."', '0')";
                        $this->db->query($cadena);
                        $id=$key->id_junta;
                        $cadena="update juntas set marcada='SI' where id_junta='".$id."' ";
                         $this->db->query($cadena);
                    }
                } 
            }
        }
    }
    public function guardar_participante($data){
        $cadena="insert into integrantes (id_usuario, id_junta, asistencia) values ('".$data["participante"]."','".$data["junta"]."','SI')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        } 
    }
    public function borra_participante($participante,$junta){
        $cadena="delete from integrantes where id_usuario='".$participante."' and id_junta='".$junta."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        } 
    }
    public function terminar_temporal($id){
        $cadena="update solucion_temporal set activo='NO' where id_temporal='".$id."'";
         $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function terminar_permanente($id){
        $cadena="update solucion_permanente set activo='NO' where id_permanente='".$id."'";
         $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function terminar_preventivo($id){
        $cadena="update solucion_preventivo set activo='NO' where id_preventivo='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function limpiar_8d($id, $tipo){
        $cadena="delete from archivos_8d where id_solucion='".$id."' and tipo_solucion='".$tipo."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function lista_equipo($id){
        $cadena="select usuario.nombre, usuario.puesto, usuario.departamento,equipo_de_trabajo.id_equipo  from equipo_de_trabajo left join usuario on equipo_de_trabajo.id_persona=usuario.id where equipo_de_trabajo.folio_8d='".$id."'";


        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }   
    }
    public function lista_equipo_sin(){
        $cadena="select usuario.nombre, usuario.puesto, usuario.departamento,equipo_de_trabajo.id_equipo  from equipo_de_trabajo left join usuario on equipo_de_trabajo.id_persona=usuario.id where equipo_de_trabajo.folio_8d='0'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }    
    }
    public function agrega_equipo2($equip,$folio){
        $cadena="insert into equipo_de_trabajo (folio_8d, id_persona) values ('".$folio."','".$equip."')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function agrega_equipo($equip){
        $cadena="insert into equipo_de_trabajo (folio_8d, id_persona) values ('0','".$equip."')";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }   
    }
    public function preventivos($num){
        $cadena="select solucion_preventivo.solucion, solucion_preventivo.fecha,solucion_preventivo.money, solucion_preventivo.f_fin, usuario.nombre, solucion_preventivo.id_preventivo,solucion_preventivo.activo from solucion_preventivo inner join usuario on solucion_preventivo.id_responsable=usuario.id where solucion_preventivo.folio_8d='".$num."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function buscar_proryecto($folio){
        $cadena="select * from proyecto where nombre_proyecto='Folio ".$folio." 8D'";
        $query  = $this->db->query($cadena);
         if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function convertir_proyecto($folio){

        $cadena="update solucion_permanente set activo='NO' where folio_8d='".$folio."'";
        $this->db->query($cadena);
        $cadena="update solucion_preventivo set activo='NO' where folio_8d='".$folio."'";
        $this->db->query($cadena);
        $cadena="update solucion_temporal set activo='NO' where folio_8d='".$folio."'";
        $this->db->query($cadena);


        $cadena="select solicitante from analisis_8d where folio='".$folio."'";
        $query  = $this->db->query($cadena)->getResult();
        $solicitante="";
        foreach ($query as $key) {
            $solicitante=$key->solicitante;
        }
        $cadena="insert into proyecto (nombre_proyecto, capitan, subcapitan,f_inicio,pendiente) values ('Folio ".$folio." 8D', '".$solicitante."','".$solicitante."',CURDATE(),'SI')";
        $this->db->query($cadena);
        $cadena="select id_proyecto from proyecto where nombre_proyecto='Folio ".$folio." 8D'";
        $query=$this->db->query($cadena)->getResult();
        $folio_proyecto="";
        foreach ($query as $key ) {
            $folio_proyecto=$key->id_proyecto;
        }
        $cadena="select solucion, id_responsable, fecha, f_fin from solucion_temporal where folio_8d='".$folio."'";
        $query=$this->db->query($cadena)->getResult();
        foreach ($query as $key ) {
           
            $cadena2="insert into subproyecto (nombre, id_usuario, f_inicio, f_fin,id_proyecto, terminado) values ('".$key->solucion."', '".$key->id_responsable."', '".$key->fecha."','".$key->f_fin."', '".$folio_proyecto."','NO')";
                $this->db->query($cadena2);
        }

        $cadena="select solucion, id_responsable, fecha, f_fin from solucion_permanente where folio_8d='".$folio."'";
        $query=$this->db->query($cadena)->getResult();
        foreach ($query as $key ) {
           
            $cadena2="insert into subproyecto (nombre, id_usuario, f_inicio, f_fin,id_proyecto, terminado) values ('".$key->solucion."', '".$key->id_responsable."', '".$key->fecha."','".$key->f_fin."', '".$folio_proyecto."','NO')";
                $this->db->query($cadena2);
        }
        $cadena="select solucion, id_responsable, fecha, f_fin from solucion_preventivo where folio_8d='".$folio."'";
        $query=$this->db->query($cadena)->getResult();
        foreach ($query as $key ) {
            
            $cadena2="insert into subproyecto (nombre, id_usuario, f_inicio, f_fin,id_proyecto, terminado) values ('".$key->solucion."', '".$key->id_responsable."', '".$key->fecha."','".$key->f_fin."', '".$folio_proyecto."','NO')";
                $this->db->query($cadena2);
        }

    }
    public function elmina_analisis($folio){
        $cadena="delete from analisis_8d where folio='".$folio."'";
        $this->db->query($cadena);
        $cadena="delete from equipo_de_trabajo where folio_8d='".$folio."'";
        $this->db->query($cadena);
        $cadena="delete from solucion_permanente where folio_8d='".$folio."'";
        $this->db->query($cadena);
        $cadena="delete from solucion_preventivo where folio_8d='".$folio."'";
        $this->db->query($cadena);
        $cadena="delete from solucion_temporal where folio_8d='".$folio."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }

    }
    public function lista_preventivos(){
        $cadena="select solucion_preventivo.solucion, solucion_preventivo.money, solucion_preventivo.fecha, solucion_preventivo.f_fin, usuario.nombre, solucion_preventivo.id_preventivo from solucion_preventivo inner join usuario on solucion_preventivo.id_responsable=usuario.id where solucion_preventivo.folio_8d='0'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }
    }
    public function lista_temporales($id){
        $cadena="select solucion_temporal.solucion, solucion_temporal.fecha,solucion_temporal.money, solucion_temporal.f_fin, usuario.nombre, solucion_temporal.id_temporal as id_solucion, solucion_temporal.activo from solucion_temporal left join usuario on solucion_temporal.id_responsable=usuario.id where solucion_temporal.folio_8d='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }   
    }
    public function temporales($folio){
        $cadena="select solucion_temporal.solucion,solucion_temporal.money, solucion_temporal.fecha, solucion_temporal.f_fin, usuario.nombre, solucion_temporal.id_temporal as id_solucion from solucion_temporal left join usuario on solucion_temporal.id_responsable=usuario.id where solucion_temporal.folio_8d='".$folio."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query->getResult();
        } else {
            return false;
        }   
    }
    public function elimina_equipo($id){
        $cadena="delete from equipo_de_trabajo where id_equipo='".$id."'";
        $query  = $this->db->query($cadena);
        if (!empty($query)) {
            return $query;
        } else {
            return false;
        }
    }
    public function lista_permanente($id){
        $cadena="select solucion_permanente.solucion, solucion_permanente.fecha,solucion_permanente.money, solucion_permanente.f_fin, solucion_permanente.id_permanente, usuario.nombre,solucion_permanente.activo from solucion_permanente inner join usuario on solucion_permanente.id_responsable=usuario.id where solucion_permanente.folio_8d='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function permanente(){
        $cadena="select solucion_permanente.solucion, solucion_permanente.money, solucion_permanente.fecha, solucion_permanente.f_fin, solucion_permanente.id_permanente, usuario.nombre from solucion_permanente inner join usuario on solucion_permanente.id_responsable=usuario.id where solucion_permanente.folio_8d='0'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function elimina_temporal($id){
        $cadena="delete from solucion_temporal where id_temporal='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }

    public function elimina_preventivo($id){
        $cadena="delete from solucion_preventivo where id_preventivo='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function elimina_permanente($id){
        $cadena="delete from solucion_permanente where id_permanente='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function carga_documentos_nivel(){
        print_r($this->loggedIn('nivel'));
        if ($this->loggedIn('tipo')=="admin"){
            $cadena="select * from documentos where estatus='A'";
        }else{
            switch ($this->loggedIn('nivel')) {
                case 'CEO':
                    $cadena="select * from documentos where estatus='A'";
                    break;
                case 'Director Sr.':
                    $cadena="select * from documentos where (nombre like '%D%' or nombre like '%MP%' or nombre like '%P%' or nombre like '%I%' or nombre like '%F%' or nombre like '%T%' or nombre like '%AV%')  and estatus='A'";
                    break;
                case 'Gerente Sr.':
                     $cadena="select * from documentos where (nombre like '%P%' or nombre like '%I%' or nombre like '%F%' or nombre like '%T%' or nombre like '%AV%')  and estatus='A'";
                    break;
                case 'Director':
                    $cadena="select * from documentos where (nombre like '%MP%' or nombre like '%P%' or nombre like '%I%' or nombre like '%F%' or nombre like '%T%' or nombre like '%AV%')  and estatus='A'";
                    break;
                case 'Gerente':
                    $cadena="select * from documentos where ( nombre like '%P%' or nombre like '%I%' or nombre like '%F%' or nombre like '%T%' or nombre like '%AV%')  and estatus='A'";
                    break;
                 case 'Staff':
                    $cadena="select * from documentos where (nombre like '%D%' or nombre like '%MP%' or nombre like '%P%' or nombre like '%I%' or nombre like '%F%' or nombre like '%T%' or nombre like '%AV%' or nombre like '%IP%' )  and estatus='A'";
                    break;
                case 'Jefe':
                    $cadena="select * from documentos where (nombre like '%I%' or nombre like '%F%' or nombre like '%T%' or nombre like '%AV%')  and estatus='A'";
                    break;
                case 'Comite Tecnico' :
                    $cadena="select * from documentos where (nombre like '%D%' or nombre like '%MP%' or nombre like '%P%' or nombre like '%I%' or nombre like '%F%' or nombre like '%T%' or nombre like '%AV%' or nombre like '%IP%' )  and estatus='A'";
                    break;
            }
        }

       
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query->getResult();
        }else{
            return false;
        }

    }
    public function guardar_solicitud($data){
        $cadena="insert into solicitud (folio, solicitante, fecha, tipo, codigo, nombre, especificar, tiempo, tipo_doc) values ('0','".$this->loggedIn('iduser')."',CURDATE(), '".$data["tipo"]."', '', '".$data["nombre_doc"]."', '".$data["especificar"]."', '1', '".$data["tipo_doc"]."')";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function agrega_permanente2($data){

         $cadena="insert into solucion_permanente   (folio_8d,solucion, id_responsable,fecha, f_fin,money, activo) values ('".$data["id"]."','".$data["solucion"]."', '".$data["responsable"]."','".$data["f_inicio"]."', '".$data["f_fin"]."','".$data["costo"]."','SI')";
         $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function agrega_permanente($data){
         $cadena="insert into solucion_permanente   (folio_8d,solucion, id_responsable,fecha, f_fin,money) values ('0','".$data["solucion"]."', '".$data["responsable"]."','".$data["f_inicio"]."', '".$data["f_fin"]."','".$data["costo"]."')";
         $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function agrega_preventivo2($data){
   
        $cadena="insert into solucion_preventivo   (folio_8d,solucion, id_responsable,fecha, f_fin, money) values ('".$data["id"]."','".$data["solucion"]."', '".$data["responsable"]."','".$data["f_inicio"]."', '".$data["f_fin"]."', '".$data["costo"]."')";

         $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function agrega_preventivo($data){
        $cadena="insert into solucion_preventivo   (folio_8d,solucion, id_responsable,fecha, f_fin, money, activo) values ('0','".$data["solucion"]."', '".$data["responsable"]."','".$data["f_inicio"]."', '".$data["f_fin"]."', '".$data["costo"]."','SI')";
         $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function agrega_temporal2($data){
        $cadena="insert into solucion_temporal (solucion, id_responsable, fecha, f_fin, folio_8d,money,activo) values ('".$data["solucion"]."', '".$data["responsable"]."','".$data["f_inicio"]."', '".$data["f_fin"]."','".$data["id"]."','".$data["monto"]."','SI')";
         $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function agrega_temporal($data){
        $cadena="insert into solucion_temporal (solucion, id_responsable, fecha, f_fin, folio_8d,money,activo) values ('".$data["solucion"]."', '".$data["responsable"]."','".$data["f_inicio"]."', '".$data["f_fin"]."','0','".$data["monto"]."','SI')";
         $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function guarda_analisis2($data){
        $cadena="update analisis_8d set tipo='".$data["tipo"]."', solicitante='".$data["solicitante"]."', problema_detectado='".$data["problema_det"]."', descripcion_problema='".$data["problema_des"]."',materia_prima='', metodos='".$data["metodos"]."',mano_de_obra='".$data["mano"]."', maquinaria='".$data["maquinaria"]."', medio_ambiente='".$data["ambiente"]."', causa_raiz='".$data["cauza_raiz"]."', lider='".$data["lider"]."', objetivo='".$data["objetivo"]."',presupuesto='".$data["presupuesto_estimado"]."' where folio='".$data["id"]."'";
        $this->db->query($cadena);
    }
    public function guarda_analisis($data){
        $cadena="select 8d as folio from configuracion";
        $folio=0;
        $query=$this->db->query($cadena)->getResult();
        foreach ($query as $key) {
            $folio=$key->folio;
        }
        $fecha = date('Y-m-j');
        $nuevafecha = strtotime ( '+7 days' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-j' , $nuevafecha );

        $cadena="insert into analisis_8d (folio, fecha,fecha_cierre, tipo, solicitante, problema_detectado,descripcion_problema, creado, notas, estatus, materia_prima, metodos, mano_de_obra, maquinaria, medio_ambiente, causa_raiz, lider,objetivo, presupuesto) values ('".$folio."',CURDATE(),'".$nuevafecha."', '".$data["tipo"]."', '".$data["solicitante"]."','".$data["problema_det"]."','".$data["problema_des"]."','".$this->loggedIn('iduser')."','','ABIERTO','".$data["materia"]."','".$data["metodos"]."','".$data["mano"]."','".$data["maquinaria"]."','".$data["ambiente"]."','".$data["cauza_raiz"]."','".$data["lider"]."','".$data["objetivo"]."','".$data["presupuesto_estimado"]."' )";
        $this->db->query($cadena);
        $cadena="update equipo_de_trabajo set folio_8d='".$folio."' where folio_8d='0'";
        $this->db->query($cadena);
        $cadena="update solucion_permanente set folio_8d='".$folio."' where folio_8d='0'";
        $this->db->query($cadena);
        $cadena="update solucion_preventivo set folio_8d='".$folio."' where folio_8d='0'";
        $this->db->query($cadena);
        $cadena="update solucion_temporal set folio_8d='".$folio."' where folio_8d='0'";
        $this->db->query($cadena);
        $cadena="update configuracion set 8d='".($folio+1)."'";
        $this->db->query($cadena);
    }
    public function pedir_proyecto_business($id){
        $cadena="select alternativas.alternativa from business inner join alternativas on business.seleccion=alternativas.id_alternativa where business.id_business='".$id."'";
        $query=$this->db->query($cadena)->getResult();
        $titulo="";
        foreach ($query as $key) {
            $titulo=$key->alternativa;
        }

        $cadena="insert into pedimentos (nombre, fecha, pidio, tipo, activo) values ('".$titulo."',CURDATE(),'".$this->loggedIn('iduser')."','proyecto','SI')";
        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        }

    }
    public function ya_pedimento($id){
        $cadena="update pedimentos set activo='NO' where id_pedimento='".$id."'";
        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function carga_8d_temporal($data){
        $cadena="select analisis_8d.problema_detectado, analisis_8d.fecha, solucion_temporal.solucion, solucion_temporal.fecha as f_inicio, solucion_temporal.f_fin, solucion_temporal.activo from analisis_8d inner join solucion_temporal on analisis_8d.id_8d=solucion_temporal.folio_8d where solucion_temporal.id_responsable='".$data["usuario"]."' and solucion_temporal.fecha>='".$data["f_inicio"]."' and solucion_temporal.f_fin<='".$data["f_fin"]."'";
        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function carga_8d_permanente($data){
        $cadena="select analisis_8d.problema_detectado, analisis_8d.fecha, solucion_permanente.solucion, solucion_permanente.fecha as f_inicio, solucion_permanente.f_fin, solucion_permanente.activo from analisis_8d inner join solucion_permanente on analisis_8d.id_8d=solucion_permanente.folio_8d where solucion_permanente.id_responsable='".$data["usuario"]."' and solucion_permanente.fecha>='".$data["f_inicio"]."' and solucion_permanente.f_fin<='".$data["f_fin"]."'";
        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function carga_8d_preventivo($data){
        $cadena="select analisis_8d.problema_detectado, analisis_8d.fecha, solucion_preventivo.solucion, solucion_preventivo.fecha as f_inicio, solucion_preventivo.f_fin, solucion_preventivo.activo from analisis_8d inner join solucion_preventivo on analisis_8d.id_8d=solucion_preventivo.folio_8d where solucion_preventivo.id_responsable='".$data["usuario"]."' and solucion_preventivo.fecha>='".$data["f_inicio"]."' and solucion_preventivo.f_fin<='".$data["f_fin"]."'";
        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function cargas_raci_responsable($data){
        $cadena="select proyecto.nombre_proyecto as proyecto , subproyecto.nombre as subproyecto, subproyecto.f_inicio, subproyecto.f_fin, subproyecto.terminado from proyecto inner join subproyecto on proyecto.id_proyecto=subproyecto.id_proyecto where subproyecto.id_usuario='".$data['usuario']."' and subproyecto.f_inicio>='".$data["f_inicio"]."' and subproyecto.f_fin<='".$data["f_fin"]."'";

        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function cargas_raci_aprobado($data){
        $cadena="select proyecto.nombre_proyecto as proyecto , subproyecto.nombre as subproyecto, subproyecto.f_inicio, subproyecto.f_fin, subproyecto.terminado from proyecto inner join subproyecto on proyecto.id_proyecto=subproyecto.id_proyecto where subproyecto.responsable='".$data['usuario']."' and subproyecto.f_inicio>='".$data["f_inicio"]."' and subproyecto.f_fin<='".$data["f_fin"]."'";

        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function cargas_raci_consultado($data){
        $cadena="select proyecto.nombre_proyecto as proyecto , subproyecto.nombre as subproyecto, subproyecto.f_inicio, subproyecto.f_fin, subproyecto.terminado from proyecto inner join subproyecto on proyecto.id_proyecto=subproyecto.id_proyecto inner join consultores on proyecto.id_proyecto=consultores.folio_proyecto where consultores.id_usuario='".$data['usuario']."' and subproyecto.f_inicio>='".$data["f_inicio"]."' and subproyecto.f_fin<='".$data["f_fin"]."'";

        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function cargas_raci_informado($data){
        $cadena="select proyecto.nombre_proyecto as proyecto , subproyecto.nombre as subproyecto, subproyecto.f_inicio, subproyecto.f_fin, subproyecto.terminado from proyecto inner join subproyecto on proyecto.id_proyecto=subproyecto.id_proyecto inner join informados on proyecto.id_proyecto=informados.folio_proyecto where informados.id_usuario='".$data["f_inicio"]."' and subproyecto.f_inicio>='".$data["f_inicio"]."' and subproyecto.f_fin<='".$data["f_fin"]."'";
        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        }

    }
    public function cargas_moderador($data){
        $cadena="select juntas.tema as nombre, juntas.lugar, juntas.impartidor, temas_juntas.tema as actividad, temas_juntas.terminado, temas_juntas.fecha_compromiso, juntas.fecha from juntas inner join temas_juntas on juntas.id_junta=temas_juntas.id_junta where juntas.impartidor='".$data["usuario"]."' and temas_juntas.fecha_compromiso BETWEEN '".$data["f_inicio"]."' and '".$data["f_fin"]."'";

        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function cargas_actividades_juntas($data){
        $cadena="select juntas.tema as nombre, juntas.lugar, juntas.impartidor, temas_juntas.tema as actividad, temas_juntas.terminado, temas_juntas.fecha_compromiso, juntas.fecha from juntas inner join temas_juntas on juntas.id_junta=temas_juntas.id_junta where temas_juntas.id_usuario_encargado='".$data["usuario"]."' and temas_juntas.fecha_compromiso BETWEEN '".$data["f_inicio"]."' and '".$data["f_fin"]."'";
        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        } 
    }
   
    public function pedimentos(){
        $cadena="select pedimentos.id_pedimento, pedimentos.nombre,pedimentos.fecha,pedimentos.tipo,usuario.nombre as pidio from pedimentos inner join usuario on pedimentos.pidio=usuario.id where pedimentos.activo='SI'";
        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function pedir_proyecto($data){
        $cadena="insert into pedimentos (nombre, fecha, pidio, tipo, activo) values ('".$data["tema"]."',CURDATE(),'".$this->loggedIn('iduser')."','".$data["tipo"]."','SI')";
        $query=$this->db->query($cadena);
         if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function salas(){
        $cadena="select * from sala_junta";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query->getResult();
        }else{
            return false;
        }
                
    }
    public function sala($id){
        $cadena="select * from sala_junta where id_sala='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query->getResult();
        }else{
            return false;
        }
    }
    public function elimina_sala($id){
        $cadena="delete from sala_junta where id_sala='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function guarda_sala_mod($data){
        $cadena="update sala_junta set nombre='".$data["nombre"]."', direccion='".$data["direccion"]."' where id_sala='".$data["numero"]."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function agregar_sala($data){
        $cadena="insert into sala_junta (nombre, direccion) values ('".$data["nombre"]."','".$data["direccion"]."')";

        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function buscar_verificacion($id){
        $cadena="select estatus from verificacion where id_documento='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query->getResult();
        }else{
            return false;
        }    
    }
    public function nuevas_solicitudes(){
        $cadena="select * from solicitud where folio='0'";

        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }   
    }
    public function siglas($id){
        $cadena="select siglas from responsables where usuario='".$id."'";
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query->getResult();
        }else{
            return false;
        }     
    }

    /**
     * Catálogo de autorizadores de documentos (tabla responsables).
     */
    public function lista_aprobadores()
    {
        return $this->db->query(
            "SELECT r.id_departamento, r.departamento, r.usuario, r.siglas, u.nombre AS nombre_usuario
             FROM responsables r
             LEFT JOIN usuario u ON u.id = r.usuario
             ORDER BY r.departamento ASC, r.siglas ASC, u.nombre ASC"
        )->getResult();
    }

    public function get_aprobador($id)
    {
        return $this->db->table('responsables')
            ->where('id_departamento', (int) $id)
            ->get()
            ->getRow();
    }

    public function departamentos_catalogo()
    {
        $rows = $this->db->query(
            "SELECT departamento FROM (
                SELECT DISTINCT departamento FROM responsables WHERE departamento IS NOT NULL AND departamento <> ''
                UNION
                SELECT DISTINCT departamento FROM usuario WHERE departamento IS NOT NULL AND departamento <> ''
             ) t
             ORDER BY departamento ASC"
        )->getResult();

        return $rows ?: [];
    }

    public function guardar_aprobador(array $data)
    {
        $payload = [
            'departamento' => trim((string) ($data['departamento'] ?? '')),
            'usuario'      => (int) ($data['usuario'] ?? 0),
            'siglas'       => strtoupper(trim((string) ($data['siglas'] ?? ''))),
        ];

        if ($payload['departamento'] === '' || $payload['usuario'] <= 0 || $payload['siglas'] === '') {
            return false;
        }

        $id = (int) ($data['id_departamento'] ?? 0);
        if ($id > 0) {
            return $this->db->table('responsables')
                ->where('id_departamento', $id)
                ->update($payload);
        }

        return $this->db->table('responsables')->insert($payload);
    }

    public function eliminar_aprobador($id)
    {
        return $this->db->table('responsables')
            ->where('id_departamento', (int) $id)
            ->delete();
    }

    public function autorizacion($usuario){
        
        if (in_array('POL',$this->loggedIn("siglas")) OR in_array('D',$this->loggedIn("siglas")) OR in_array('OR',$this->loggedIn("siglas")) OR in_array('IP',$this->loggedIn("siglas")) ){
            $cadena="(select documentos.id, documentos.nombre, documentos.departamento, documentos.tipo from documentos left join verificacion on documentos.id=verificacion.id_documento where documentos.tipo='POL' AND documentos.estatus='P' and verificacion.estatus='A')UNION(select documentos.id, documentos.nombre, documentos.departamento, documentos.tipo from documentos left join verificacion on documentos.id=verificacion.id_documento where documentos.tipo='D' AND documentos.estatus='P' and verificacion.estatus='A') UNION(select documentos.id, documentos.nombre, documentos.departamento, documentos.tipo from documentos left join verificacion on documentos.id=verificacion.id_documento where documentos.tipo='OR' AND documentos.estatus='P' and verificacion.estatus='A') UNION (select distinct documentos.id, documentos.nombre, documentos.departamento, documentos.tipo from documentos inner join responsables on documentos.departamento=responsables.departamento and documentos.tipo=responsables.siglas where documentos.estatus='P' and responsables.usuario='".$usuario."')";
        }else{
             $cadena="select distinct documentos.id, documentos.nombre, documentos.departamento, documentos.tipo from documentos inner join responsables on documentos.departamento=responsables.departamento and documentos.tipo=responsables.siglas where documentos.estatus='P' and responsables.usuario='".$usuario."'";
        }
        $query=$this->db->query($cadena);
         
                if (!empty($query)){
                    return $query;
                }else{
                    return false;
                }
             


    }
    public function revisar_doc($id){
        $cadena="select count(*) as total from verificacion where id_documento='".$id."' and estatus='P'";
       
        $query=$this->db->query($cadena);
        if (!empty($query)){
            return $query->getResult();
        }else{
            return false;
        }
    }
    public function guarda_estatus_doc2($data){

        $cadena="select tipo from documentos where id='".$data["id"]."'";
        $query=$this->db->query($cadena)->getResult();
        if ($query[0]->tipo=="I" OR $query[0]->tipo=="F" OR $query[0]->tipo=="MP" OR $query[0]->tipo=="T"){
            $cadena="update documentos set estatus='A' where id='".$data["id"]."'  ";
            $this->db->query($cadena);
        }

        $cadena="update verificacion set estatus='".$data["estatus"]."' where id_documento='".$data["id"]."' and id_usuario='".$this->loggedIn('iduser')."' ";
        $query=$this->db->query($cadena);
        if (isset($data["mensaje"])){
            $cadena="insert into mensajes_doc (id_documento, mensaje, fecha) values ('".$data["id"]."', '".$data["mensaje"]."', CURDATE())";
            $query=$this->db->query($cadena);
        }
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
    public function guarda_estatus_doc($data){
        $cadena="update documentos set estatus='".$data["estatus"]."', activo='NO' where id='".$data["id"]."'";
        $query=$this->db->query($cadena);
        if (isset($data["mensaje"])){
            $cadena="insert into mensajes_doc (id_documento, mensaje, fecha) values ('".$data["id"]."', '".$data["mensaje"]."', CURDATE())";
            $query=$this->db->query($cadena);
        }
        if (!empty($query)){
            return $query;
        }else{
            return false;
        }
    }
}
