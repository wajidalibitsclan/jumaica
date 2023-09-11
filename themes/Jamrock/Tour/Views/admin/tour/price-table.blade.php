<div class="form-group-item" id="priceTable">
    <label class="control-label">{{__('Pricing Table')}}</label>
    <div class="g-items-header">
        <div class="row">
            <div class="col-lg-4 pr-lg-0">
                <div class="table-responsive">
                    <table class="table table-bordered border-white" ref="priceTable">
                        <thead>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                        <tr>
                            <th colspan="3" class="bg-success text-white">{{__('Google Distance (Km)')}}</th>
                        </tr>
                        <tr>
                            <td colspan="3" class="bg-success text-white">
                                <div class="d-flex justify-content-between">
                                    <span>{{__('Ranger #')}}</span>
                                    <span>{{__('Form (Km)')}}</span>
                                    <span>{{__('To (Km)')}}</span>
                                </div>
                            </td>
                        </tr>
                        </thead>
                        <tbody class="table-striped">
                            <tr v-for="(value,index) in distance" :key="index">
                                <td><input type="number" min="0" step="1" :key="index" :value="index+1"    class="form-control"></td>
                                <td><input type="number" min="0" step="1" :key="index+'from'"  v-model.number="distance[index].from" :name="'distance['+index+'][from]'"   class="form-control"></td>
                                <td><input type="number" min="0" step="1" :key="index+'to'"  v-model.number="distance[index].to" :name="'distance['+index+'][to]'"   class="form-control"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-8 pl-lg-0">
                <div class="table-responsive">
                    <table class="table table-bordered border-white" ref="priceTable">
                        <thead>
                        <tr>
                            <th v-bind:colspan="json_column_pax.length +1" class="bg-success text-white">{{__('Number Of Passenger (Ranges)')}}</th>
                        </tr>
                        <tr >
                            <th class="bg-warning" v-for="(column,index) in json_column_pax" :key="index">
                                <div>{{__('Pax Range')}}</div>
                                <div class="d-flex  w-100 justify-content-between">
                                    <span>Fr</span>
                                    <span>-</span>
                                    <span>To</span>
                                </div>
                                <div class="d-flex">
                                    <input type="number" min="0" step="1"  v-model.number="column.form" :name="'pax_ranger['+index+'][form]'"   class="form-control">
                                    <input type="number" min="0" step="1"  v-model.number="column.to" :name="'pax_ranger['+index+'][to]'"  class="form-control">
                                </div>
                                <div class="d-flex w-100 mt-1 justify-content-between">
                                    <span>Price</span>
                                    <span>Discount</span>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="table-striped">
                        <tr v-for="(row,r) in rangers" :key="r">
                            <td class="text-center" v-for="(column,index) in json_column_pax" :key="index">
                                <div class="d-flex">
                                    <input type="hidden"  v-model.number="column.form" :name="'rangers['+r+']['+index+'][pax_from]'"  class="form-control">
                                    <input type="hidden"  v-model.number="column.to" :name="'rangers['+r+']['+index+'][pax_to]'"  class="form-control">

                                    <input type="number" min="0" step="1"  v-model.number="rangers[r][index].price"      :name="'rangers['+r+']['+index+'][price]'"  class="form-control">
                                    <input type="number" min="0" step="1"  v-model.number="rangers[r][index].discount"  :name="'rangers['+r+']['+index+'][discount]'"  class="form-control">
                                </div>
                            </td>
                            <td><span @click="deleteRow(r)" class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <th  v-for="(column,index) in json_column_pax" :key="index">
                            <span @click="deleteColumn(index)" class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                        </th>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-12">
                <div class="btn btn-info" @click="addColumn"><i class="icon ion-ios-add-circle-outline"></i> {{__("Add Column")}}</div>
                <div class="btn btn-info" @click="addRow"><i class="icon ion-ios-add-circle-outline"></i> {{__("Add Row")}}</div>
            </div>
        </div>
    </div>
</div>
