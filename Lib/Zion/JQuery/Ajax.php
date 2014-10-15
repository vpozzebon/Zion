<?phpnamespace Zion\JQuery;class Ajax{    private $config;    private $type;    private $definicoes;    private $complementos;    public function __construct()    {        $this->definicoes = [            'url',            'accepts',            'async',            'beforeSend',            'cache',            'complete',            'contents',            'contentType',            'context',            'crossDomain',            'data',            'dataFilter',            'dataType',            'error',            'global',            'headers',            'ifModified',            'isLocal',            'jsonp',            'jsonpCallback',            'mimeType',            'password',            'processData',            'script',            'scriptCharset',            'statusCode',            'success',            'timeout',            'traditional',            'username'        ];        $this->complementos = [            'done',            'fail',            'always'        ];    }    /**     *      * @return AjaxVO     */    public function ajaxConfig()    {        $this->config = new AjaxVO();        return $this->config;    }    public function get()    {        $this->type = 'get';        return $this->montaAjax();    }    public function getJSON()    {        $this->type = 'json';        return $this->montaAjax();    }    public function getScript()    {        $this->config->setDataType('script');        return $this->montaAjax();    }    public function post()    {        $this->type = 'post';        return $this->montaAjax();    }    public function load($container, $url, $funcaoAoCompletar = '')    {        $aoCompletar = $funcaoAoCompletar ? ',' . $funcaoAoCompletar : '';        return ' $("#' . $container . '").load("' . $url . $aoCompletar . '"); ';    }    private function montaAjax()    {        $arrayConf = [            'definicoes' => [],            'complementos' => []];                $arrayConf['definicoes'][] = 'type:'.$this->type;                foreach ($this->definicoes as $nomeDefinicao) {                        $metodo = 'get'.$nomeDefinicao.'()';                        $conteudoGet = $this->config->$metodo;                        if($conteudoGet){                $arrayConf['definicoes'][] = $nomeDefinicao.':'.$conteudoGet;            }        }        foreach ($this->complementos as $nomeComplemento) {                        $metodo = 'get'.$nomeComplemento.'()';                        $conteudoGet = $this->config->$metodo;                        if($conteudoGet){                $arrayConf['complementos'][] = $nomeComplemento.'(function(ret) {'.$conteudoGet.'})';            }        }        $strAjax1 = ' $.ajax({ '.  implode(',', $arrayConf['definicoes']).' })';        $strAjax2 = implode(',', $arrayConf['complementos']).'; ';        return $strAjax1.$strAjax2;    }}