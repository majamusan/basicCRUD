<?php

namespace basicCRUD\Http\Controllers;

use Illuminate\Http\Request, basicCRUD\CRUD, Session;

class crudController extends Controller
{
    private $languageOptions = [
    	'aar'=>'Afar',
    	'abk'=>'Abkhazian',
    	'ace'=>'Achinese',
    	'ach'=>'Acoli',
    	'ada'=>'Adangme',
    	'ady'=>'Adyghe',
    	'afa'=>'Afro-Asiatic languages',
    	'afh'=>'Afrihili',
    	'afr'=>'Afrikaans',
    	'ain'=>'Ainu',
    	'aka'=>'Akan',
    	'akk'=>'Akkadian',
    	'sqi'=>'Albanian',
    	'ale'=>'Aleut',
    	'alg'=>'Algonquian languages',
    	'alt'=>'Southern Altai',
    	'amh'=>'Amharic',
    	'ang'=>'Anglo-Saxon',
    	'anp'=>'Angika',
    	'apa'=>'Apache languages',
    	'ara'=>'Arabic',
    	'arc'=>'Imperial Aramaic (700-300 BCE)',
    	'arg'=>'Aragonese',
    	'hye'=>'Armenian',
    	'arn'=>'Mapudungun',
    	'arp'=>'Arapaho',
    	'art'=>'Artificial languages',
    	'arw'=>'Arawak',
    	'asm'=>'Assamese',
    	'ast'=>'Asturian',
    	'ath'=>'Athapascan languages',
    	'aus'=>'Australian languages',
    	'ava'=>'Avaric',
    	'ave'=>'Avestan',
    	'awa'=>'Awadhi',
    	'aym'=>'Aymara',
    	'aze'=>'Azerbaijani',
    	'bad'=>'Banda languages'
	];

    private $interestOptions = [
        'Outdoor' => ['swimming' => 'Swimming','walking'=>'Walking'],
        'Indoor' => ['painting' => 'Painting','programming'=>'Programming'],
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $crud = CRUD::where('name', 'LIKE', "%$keyword%")
                ->orWhere('surname', 'LIKE', "%$keyword%")
                ->orWhere('mobile', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('ID_Number', 'LIKE', "%$keyword%")
                ->orWhere('birth', 'LIKE', "%$keyword%")
                ->orWhere('language', 'LIKE', "%$keyword%")
                ->orWhere('interests', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $crud = CRUD::paginate($perPage);
        }

        $languageOptions = $this->languageOptions;
        return view('crud.index', compact(['crud','languageOptions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('crud.create',[
            'crud'=>(object)['language'=>'','interests'=>''],
            'interestOptions'=>$this->interestOptions,
            'languageOptions'=>$this->languageOptions
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'ID_Number' => 'required|unique:crud|min:13|max:13',
            'mobile' => 'required|unique:crud|min:10|max:15',
            'email' => 'required|unique:crud|email',
            'birth' => 'required|date|before:today',
            'language' => 'required',
            'interests' => 'required|array',
        ]);

        $requestData = $request->all();
        $requestData['interests'] = json_encode($requestData['interests']);
        CRUD::create($requestData);
        Session::flash('flash_message', 'Post added!');
        return redirect('crud');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $crud = CRUD::findOrFail($id);
        $languageOptions = $this->languageOptions;
        $crud->interests = implode(' & ',json_decode($crud->interests));
        return view('crud.show', compact('crud','languageOptions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $interestOptions = $this->interestOptions;
        $languageOptions = $this->languageOptions;
        $crud = CRUD::findOrFail($id);
        $crud->interests = json_decode($crud->interests);
        return view('crud.edit', compact('crud','interestOptions', 'languageOptions'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        $requestData['interests'] = json_encode($requestData['interests']);
        $crud = CRUD::findOrFail($id);
        $crud->update($requestData);
        Session::flash('flash_message', 'Post updated!');
        return redirect('crud');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CRUD::destroy($id);
        Session::flash('flash_message', 'Post deleted!');
        return redirect('crud');
    }
}
