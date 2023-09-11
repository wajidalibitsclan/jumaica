new Vue({
    el:'#priceTable',
    data:{
        json_column_pax:json_column_pax,
        distance:json_distance,
        rangers:json_rangers,
        distance_item_default:{
            range:0,
            from:0,
            to:0
        },
        ranger_item_default:{
            price:0,
            discount:0
        },
    },
    created:function () {

    },
    methods:{
        test(range,index){
            console.log(range,index)
        },
        addColumn:function (){
            this.json_column_pax.push([0,0])
            this.rangers.map(function (value,index){
                let ranger_item = Object.assign({},this.ranger_item_default)
                value.push(ranger_item)
            })
        },
        addRow:function (){
            let distance_item = Object.assign({},this.distance_item_default)
            this.distance.push(distance_item);
            let ranger_item_push=[];
            for (let i=1;i<= this.json_column_pax.length;i++){
                const ranger_item = Object.assign({},this.ranger_item_default)
                ranger_item_push.push(ranger_item);
            }
            this.rangers.push(ranger_item_push);
        },
        deleteColumn(index){
            this.json_column_pax.splice(index,1);
            this.rangers.map(function (value,i){
                value.splice(index,1);
            })
        },
        deleteRow(index){
            this.distance.splice(index,1);
            this.rangers.splice(index,1);
        }

    }
})
