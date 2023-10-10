if(Request()->ajax()){
            return "Hola";
        }


        $(document).on('click', '#agregar', function(){
            $.ajax({
                url: '/purchaseOrder/ajax',
                type: 'GET',
                success: function(response){
                    console.log(response);
                }
            })
        });



        return response()->json(['success'=>'Got Simple Ajax Request.']);
                return response()->json(['success'=>$input]);
                var_dump($articles);

                public function ajax(Request $request){
        $articles = Article::all();
        return $articles;
    }

    document.getElementById("tableArticle").insertRow(-1).innerHTML = 
                            '<tr>'+
                                '<th scope="row">-</th>'+
                                '<td>-</td>'+
                                '<td>-</td>'+
                                '<td>-</td>'+
                                '<td>-</td>'+
                                '<td>-</td>'+
                                '<td>-</td>'+
                                '<td>-</td>'+
                                '<td>-</td>'+
                                '<td>-</td>'+
                                '<td>-</td>'+
                                '<td>-</td>'+
                                '<td>-</td>'+
                                '<td>'+
                                    '<div class="col">'+
                                        '<div class="row mx-auto my-2 w-100 justify-content-center">'+
                                            '<button type="button" class="btn btn-success col-md-12 mx-auto btn-block" data-toggle="modal" data-target="#">Ver</button>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>'
                            $codeArticle = $request->get('codeArticle');
        $nameArticle = $request->get('nameArticle');

        $table->id();
            
            $table->foreignId('codePurchase')->constrained('purchases')->nullable();
            $table->foreignId('codeArticle')->constrained('articles');
            $table->integer('amountArticle');
            $table->integer('pendingAmountArticle');
            $table->decimal('unitPriceArticle', 8, 2);

            $table->timestamps();


            DELETE FROM `purchase_details` WHERE `codeArticle` = 1 AND `codePurchase` IS NULL

            $('#paymentConditionSelect option:selected').val()
            $('#paymentConditionSelect option:selected').html() <- Imprime el texto

            /*$updatePurchase = DB::table('purchase_details')
            ->where('codePurchase', NULL)
            ->update([ 'codePurchase' => $idPurchase]);*/

        $updatePurchase = PurchaseDetail::get('id')->where('codePurchase', '=', 'NULL');
        return $updatePurchase;

        //return redirect()->back();

        <div class="row mb-4">
                                    <div class="col"> 
                                        <input type="text" name="" class="form-control col-md-12 my-1" id="nameArticle" placeholder="Artículo">
                                    </div>
                                    <div class="col">
                                        <input type="text" name="" class="form-control col-md-12 my-1" id="amountArticle" placeholder="Cantidad">
                                    </div>
                                    <div class="col">
                                        <input type="text" name="" class="form-control col-md-12 my-1" id="unitPriceArticle" placeholder="Precio unit.">
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-secondary col-md-12 my-1" id="addToListArticle">Agregar</button>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-secondary col-md-12 my-1">Cancelar</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group mb-1">
                                            <input type="text" class="form-control" placeholder="Ingrese código de artículo" aria-describedby="basic-addon2" name="search" id="codeArticle" type="search" value="">
                                            <input type="text" class="form-control" placeholder="Ingrese código de artículo" aria-describedby="basic-addon2" name="search" id="codeArticle" type="search" value="">
                                            <input type="text" class="form-control" placeholder="Ingrese código de artículo" aria-describedby="basic-addon2" name="search" id="codeArticle" type="search" value="">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" id="submitArticle">Agregar</button>
                                                <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#modal-find-article">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                @if($filterSearch == 'codeArticle')
                                                    <option selected="" value="codeArticle">Código</option>
                                                @endif
                                                @if($filterSearch != 'codeArticle')
                                                    <option value="codeArticle">Código</option>
                                                @endif
                                                @if($filterSearch == 'nameType')
                                                    <option selected="" value="nameType">Tipo</option>
                                                @endif
                                                @if($filterSearch != 'nameType')
                                                    <option value="nameType">Tipo</option>
                                                @endif
                                                @if($filterSearch == 'nameArticle')
                                                    <option selected="" value="nameArticle">Descripción</option>
                                                @endif
                                                @if($filterSearch != 'nameArticle')
                                                    <option value="nameArticle">Descripción</option>
                                                @endif
                                                @if($filterSearch == 'modelArticle')
                                                    <option selected="" value="modelArticle">Modelo</option>
                                                @endif
                                                @if($filterSearch != 'modelArticle')
                                                    <option value="modelArticle">Modelo</option>
                                                @endif
                                                @if($filterSearch == 'referenceArticle')
                                                    <option selected="" value="referenceArticle">Referencia</option>
                                                @endif
                                                @if($filterSearch != 'referenceArticle')
                                                    <option value="referenceArticle">Referencia</option>
                                                @endif
                                                @if($filterSearch == 'weightArticle')
                                                    <option selected="" value="weightArticle">Peso</option>
                                                @endif
                                                @if($filterSearch != 'weightArticle')
                                                    <option value="weightArticle">Peso</option>
                                                @endif
                                                @if($filterSearch == 'locationArticle')
                                                    <option selected="" value="locationArticle">Ubicación</option>
                                                @endif
                                                @if($filterSearch != 'locationArticle')
                                                    <option value="locationArticle">Ubicación</option>
                                                @endif
                                                @if($filterSearch == 'nameLine')
                                                    <option selected="" value="nameLine">Línea</option>
                                                @endif
                                                @if($filterSearch != 'nameLine')
                                                    <option value="nameLine">Línea</option>
                                                @endif
                                                @if($filterSearch == 'nameSubline')
                                                    <option selected="" value="nameSubline">Sublínea</option>
                                                @endif
                                                @if($filterSearch != 'nameSubline')
                                                    <option value="nameSubline">Sublínea</option>
                                                @endif
                                                @if($filterSearch == 'nameGroup')
                                                    <option selected="" value="nameGroup">Grupo</option>
                                                @endif
                                                @if($filterSearch != 'nameGroup')
                                                    <option value="nameGroup">Grupo</option>
                                                @endif
                                                @if($filterSearch == 'nameOrigin')
                                                    <option selected="" value="nameOrigin">Procedencia</option>
                                                @endif
                                                @if($filterSearch != 'nameOrigin')
                                                    <option value="nameOrigin">Procedencia</option>
                                                @endif
                                                @if($filterSearch == 'nameProvider')
                                                    <option selected="" value="nameProvider">Proveedor</option>
                                                @endif
                                                @if($filterSearch != 'nameProvider')
                                                    <option value="nameProvider">Proveedor</option>
                                                @endif


                            <div class="row">
                                @if($search)
                                    <div class="col">
                                        <div class="alert alert-success mt-0 mb-3 row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                                    </div>
                                @endif
                            </div>

                            @if ($search)
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-success mt-0 mb-3 row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                                    </div>
                                </div>
                            @endif


                                    public function line()
    {
        return $this->hasOne('App\Models\ArticleDependencies\Line');
    }
    public function subline()
    {
        return $this->hasOne('App\Models\ArticleDependencies\Subline');
    }
    public function group()
    {
        return $this->hasOne('App\Models\ArticleDependencies\Group');
    }
    public function origin()
    {
        return $this->hasOne('App\Models\ArticleDependencies\Origin');
    }
    public function type()
    {
        return $this->hasOne('App\Models\ArticleDependencies\Type');
    }

            

            
public function store(Request $request)
    {
        $stateSale = '1';
        $typeSale = '1';

        /*$newQuotation = new Sale();
        $newQuotation->codeSale = $request->codeSale;
        $newQuotation->customerSale = $request->customerSale;
        $newQuotation->paymentSale = $request->paymentSale;
        $newQuotation->stateSale = $stateSale;
        $newQuotation->descriptionSale = $request->descriptionSale;
        $newQuotation->typeSale = $typeSale;
        $newQuotation->userSale = $request->userSale;
        $newQuotation->save();*/

        // ----------------------------------------------------------------------- //

        $idSale = Sale::get('id')->last();

        //$updateDetail = SaleDetail::where('codeSale', NULL)
            //->update(['codeSale' => $idSale->id]);
        
        //return $updateDetail;

        // ----------------------------------------------------------------------- //

        //return redirect()->back();
    }
            

            $table->id();
            $table->foreignId('codePurchase')->constrained('purchases');
            $table->foreignId('accountPayableType')->constrained('account_payable_types');
            $table->foreignId('codeProvider')->constrained('providers');
            $table->foreignId('paymentAccountPayable')->constrained('payment_conditions');
            $table->decimal('amountAccountPayable', 12, 2);
            $table->timestamps();

            $table->id();

            $table->string('codeAccountReceivableType', 12);
            $table->string('nameAccountReceivableType', 50);

            $table->timestamps();


            @foreach ($accountPayables as $accountPayable)
                                        <tr>
                                            <th hidden="hidden">{{ $accountPayable->id }}</th>
                                            <th scope="row">{{ $accountPayable->codePurchase }}</th>
                                            <td>{{ $accountPayable->nameAccountPayableType }}</td>
                                            <td>{{ $accountPayable->nameProvider }}</td>
                                            <td>{{ $accountPayable->namePayment }}</td>
                                            <td>{{ $accountPayable->codeCurrency }}</td>
                                            <td>{{ $accountPayable->nameBank }}</td>
                                            <td>{{ $accountPayable->amountDocument }}</td>
                                            <td>{{ $accountPayable->amountAccountPayable }}</td>
                                            <td><button type="button" class="btn btn-primary btn-sm" id="selectAccountPayable">Selec.</button></td>
                                        </tr>
                                        @endforeach

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$table->id();

            $table->string('codeAccountPayableType', 12);
            $table->string('nameAccountPayableType', 50);

            $table->timestamps();

            $table->id();

            $table->string('codeAccountReceivableType', 12);
            $table->string('nameAccountReceivableType', 50);

            $table->timestamps();

            $table->id();
            $table->foreignId('codePurchase')->constrained('purchases')->nullable();
            $table->string('codeAccountPayable', 12)->nullable();
            $table->foreignId('codeAccountPayableType')->constrained('account_payable_types');
            $table->foreignId('codeProvider')->constrained('providers');
            $table->foreignId('codePayment')->constrained('payment_conditions');
            $table->foreignId('codeCurrency')->constrained('currencies');
            $table->foreignId('codeBank')->constrained('banks');
            $table->decimal('amountAccountPayable', 12, 2);
            $table->timestamps();

            $table->id();
            $table->foreignId('codeSale')->constrained('sales')->nullable();
            $table->string('codeAccountReceivable', 12)->nullable();
            $table->foreignId('codeAccountReceivableType')->constrained('account_receivable_types');
            $table->foreignId('codeCustomer')->constrained('customers');
            $table->foreignId('codePayment')->constrained('payment_conditions');
            $table->foreignId('codeCurrency')->constrained('currencies');
            $table->foreignId('codeBank')->constrained('banks');
            $table->decimal('amountDocument', 12, 2);
            $table->decimal('amountAccountReceivable', 12, 2)->nullable();
            $table->timestamps();                                        










            @if($AR->amountDocument == $AR->amountAR)
                                                        <tr>
                                                            <th hidden="hidden">{{ $AR->id }}</th>
                                                            <th scope="row">{{ $AR->codeSale }}</th>
                                                            <td>{{ $AR->nameARType }}</td>
                                                            <td>{{ $AR->nameCustomer }}</td>
                                                            <td>{{ $AR->namePayment }}</td>
                                                            <td>{{ $AR->codeCurrency }}</td>
                                                            <td>{{ $AR->nameBank }}</td>
                                                            <td>{{ $AR->amountDocument }}</td>
                                                            <td>{{ $AR->amountAR }}</td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="9">
                                                                <div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen cuentas por cobrar actuales</div>
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @if($AR->amountDocument == $AR->amountAR)
                                                <tr>
                                                    <td colspan="9">
                                                        <div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen cuentas por cobrar actuales</div>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <th hidden="hidden">{{ $AR->id }}</th>
                                                    <th scope="row">{{ $AR->codeSale }}</th>
                                                    <td>{{ $AR->nameARType }}</td>
                                                    <td>{{ $AR->nameCustomer }}</td>
                                                    <td>{{ $AR->namePayment }}</td>
                                                    <td>{{ $AR->amountDocument }}</td>
                                                    <td><button type="button" class="btn btn-primary btn-sm" id="selectAccountReceivable">Selec.</button></td>
                                                </tr>
                                            @endif



                                             @foreach ($AR2s as $AR)
                                                    @if($AR->amountDocument == $AR->amountAR)
                                                        <tr>
                                                            <th hidden="hidden">{{ $AR->id }}</th>
                                                            <th scope="row">{{ $AR->codeSale }}</th>
                                                            <td>{{ $AR->nameARType }}</td>
                                                            <td>{{ $AR->nameCustomer }}</td>
                                                            <td>{{ $AR->namePayment }}</td>
                                                            <td>{{ $AR->codeCurrency }}</td>
                                                            <td>{{ $AR->nameBank }}</td>
                                                            <td>{{ $AR->amountDocument }}</td>
                                                            <td>{{ $AR->amountAR }}</td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td colspan="9">
                                                                <div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen cuentas por cobrar actuales</div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach









                                            @if($AR->amountDocument == $AR->amountAR || $AR->amountAR < $AR->amountDocument)
                                                <tr>
                                                    <th hidden="hidden">{{ $AR->id }}</th>
                                                    <th hidden="hidden">{{ $AR->codeCurrency }}</th>
                                                    <th hidden="hidden">{{ $AR->codeBank }}</th>
                                                    <th scope="row">{{ $AR->codeSale }}</th>
                                                    <td>{{ $AR->nameARType }}</td>
                                                    <td>{{ $AR->nameCustomer }}</td>
                                                    <td>{{ $AR->namePayment }}</td>
                                                    <td>{{ $AR->nameCurrency }}</td>
                                                    <td>{{ $AR->nameBank }}</td>
                                                    <td>{{ $AR->amountDocument }}</td>
                                                    <td>{{ $AR->amountAR }}</td>
                                                    <td><button type="button" class="btn btn-primary btn-sm" id="selectAccountReceivable">Selec.</button></td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="9">
                                                        <div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen cuentas por cobrar actuales</div>
                                                    </td>
                                                </tr>
                                            @endif



@foreach ($ARs as $AR)
                                            @if($AR->amountAR == 0.00)
                                                <tr>
                                                    <td colspan="9">
                                                        <div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen más cuentas por cobrar actuales</div>
                                                    </td>
                                                </tr>
                                            @else
                                                @if(
                                                    ($AR->amountDocument == $AR->amountAR) || 
                                                (
                                                    ($AR->amountAR > 0) && ($AR->amountAR < $AR->amountDocument)
                                                )

                                                )
                                                <tr>
                                                    <th hidden="hidden">{{ $AR->id }}</th>
                                                    <th hidden="hidden">{{ $AR->codeCurrency }}</th>
                                                    <th hidden="hidden">{{ $AR->codeBank }}</th>
                                                    <th scope="row">{{ $AR->codeSale }}</th>
                                                    <td>{{ $AR->nameARType }}</td>
                                                    <td>{{ $AR->nameCustomer }}</td>
                                                    <td>{{ $AR->namePayment }}</td>
                                                    <td>{{ $AR->nameCurrency }}</td>
                                                    <td>{{ $AR->nameBank }}</td>
                                                    <td>{{ $AR->amountDocument }}</td>
                                                    <td>{{ $AR->amountAR }}</td>
                                                    <td><button type="button" class="btn btn-primary btn-sm" id="selectAccountReceivable">Selec.</button></td>
                                                </tr>
                                                @endif
                                            @endif
                                        @endforeach


@if($AR->amountAR == 0.00)
                                                        <tr>
                                                            <th hidden="hidden">{{ $AR->id }}</th>
                                                            <th scope="row">{{ $AR->codeSale }}</th>
                                                            <td>{{ $AR->nameARType }}</td>
                                                            <td>{{ $AR->nameCustomer }}</td>
                                                            <td>{{ $AR->namePayment }}</td>
                                                            <td>{{ $AR->nameCurrency }}</td>
                                                            <td>{{ $AR->nameBank }}</td>
                                                            <td>{{ $AR->amountDocument }}</td>
                                                        </tr>
                                                    @else
                                                        @if(
                                                            ($AR->amountDocument == $AR->amountAR) || 
                                                        (
                                                            ($AR->amountAR > 0) && ($AR->amountAR < $AR->amountDocument)
                                                        )
                                                        
                                                        )
                                                        <tr>
                                                            <td colspan="9">
                                                                <div class="alert alert-success mb-0 row mx-auto w-100 justify-content-center" role="alert">Existe una o más cuentas por cobrar para registrar</div>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endif
                                                @endforeach

                                                date('d-m-Y h:m:s', strtotime($quotation->created_at))
                                                date_format(`created_at`, '%d-%m-%y') LIKE '%07-02%'




/*Route::get('/employees', 'HomeController@employees')->name('employees');
Route::get('/employees/index', 'EmployeesController@index')->name('employees');
Route::post('/employees/store', 'EmployeesController@store')->name('employees.store');
Route::post('/employees/{id_employee}/update', 'EmployeesController@update')->name('employees.update');
Route::delete('/employees/{id_employee}/delete', 'EmployeesController@delete')->name('employees.delete');*/

<!--<li class="nav-item">
                            <a class="nav-link" href="{{ route ('employees') }}">Empleados<span class="sr-only">(current)</span></a>
                        </li>-->
                        <!-- -->







                                            