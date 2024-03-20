<script setup>
import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { VDataTable } from 'vuetify/labs/VDataTable';
const router = useRouter();
const store = UserStore();
let data = ref(); 
           
    axios.get("/api/customers").then(res=>{
        if(res.data.success){ 
        data.value = res.data.data 
        headers.value = Object.keys(data.value[0]).map(v=>{ return  {title:v, key:v }})
        } 
        else{
            store.setMsgbox({status:false, msg:"Failed to load data"}); 
        }
    }).catch(function (error) {
        store.setMsgbox({status:false, msg:error}); 
    }); 
 
    const edit = (id)=>{
      router.push({path: '/customers/edit/'+id})
    }; 
    
    const remove = (id, index)=>{  
      if(confirm("Are you sure")){
        axios.delete("/api/customers/"+id).then(res=>{
        if(res.data.success){ 
            data.value.splice(index, 1);   
            store.setMsgbox({status:true, msg:"Successfully Removed"});
        }  
        }).catch(function (error) {
            store.setMsgbox({status:false, msg:"Failed to remove"});
        });  
      }
    };
    

  const log_table = ref({})
  log_table.value = {
    itemsPerPage: 5,
      headers: [
        {
          title: 'Dessert (100g serving)',
          align: 'start',
          sortable: false,
          key: 'name',
        },
        { title: 'Calories', key: 'calories', align: 'end' },
        { title: 'Fat (g)', key: 'fat', align: 'end' },
        { title: 'Carbs (g)', key: 'carbs', align: 'end' },
        { title: 'Protein (g)', key: 'protein', align: 'end' },
        { title: 'Iron (%)', key: 'iron', align: 'end' },
      ],
      serverItems: [],
      loading: true,
      totalItems: 0
    };
  
     const loadItems = ({ page, itemsPerPage, sortBy })=> {
        log_table.loading = true
        axios.get(`/api/staff/${id}`).then(res=>{
          if(res.data.success){ 
            log_table.value = res.data.data ;
              // console.log(data);
            } 
            else{
                store.setMsgbox({status:false, msg:"Failed to load data"}); 
            }
        }).catch(function (error) {
            store.setMsgbox({status:false, msg:error}); 
        });   
     }

    // const headers = ["name", "tel", "payable", "receivable", "Action"]
    const headers = ref([])
    const god = ref([])
    // headers.value = [{title:"name"}, {title:"tel"}, {title:"payable"}, {title:"receivable"}]

    // headers.value = [
    //     {
    //       title: 'Name',
    //       align: 'start',
    //       sortable: false,
    //       key: 'name',
    //     },
    //     { title: 'Tel', key: 'tel', align: 'end' },
    //     { title: 'Payable', key: 'payable', align: 'end' },
    //     { title: 'Receivable', key: 'receivable', align: 'end' },
    //     { title: 'Action', key: 'action', align: 'end' } 
    //   ];

      // god.value = [
      //   {
      //     name: 'Name',
      //     tel: 'start',
      //     payable: 'false',
      //     receivable: 'name',
      //     key:1
      //   },
      //   {
      //     name: 'Name',
      //     tel: 'start',
      //     payable: 'false',
      //     receivable: 'name',
      //     key:2
      //   } 
      // ];
      god.value = [
          {
            name: '🍎 Apple',
            location: 'Washington',
            height: '0.1',
            base: '0.07',
            volume: '0.0001',
          },
          {
            name: '🍌 Banana',
            location: 'Ecuador',
            height: '0.2',
            base: '0.05',
            volume: '0.0002',
          },
          {
            name: '🍇 Grapes',
            location: 'Italy',
            height: '0.02',
            base: '0.02',
            volume: '0.00001',
          },
          {
            name: '🍉 Watermelon',
            location: 'China',
            height: '0.4',
            base: '0.3',
            volume: '0.03',
          },
          {
            name: '🍍 Pineapple',
            location: 'Thailand',
            height: '0.3',
            base: '0.2',
            volume: '0.005',
          },
          {
            name: '🍒 Cherries',
            location: 'Turkey',
            height: '0.02',
            base: '0.02',
            volume: '0.00001',
          },
          {
            name: '🥭 Mango',
            location: 'India',
            height: '0.15',
            base: '0.1',
            volume: '0.0005',
          },
          {
            name: '🍓 Strawberry',
            location: 'USA',
            height: '0.03',
            base: '0.03',
            volume: '0.00002',
          },
          {
            name: '🍑 Peach',
            location: 'China',
            height: '0.09',
            base: '0.08',
            volume: '0.0004',
          },
          {
            name: '🥝 Kiwi',
            location: 'New Zealand',
            height: '0.05',
            base: '0.05',
            volume: '0.0001',
          },
        ]
// const headers = Object.keys(data.value)//.map(v=>{ return  {title:v, key:v }})

</script> 
<template>   
<VRow>  
  {{ headers }}
  <VDataTable    
    :headers = "headers"
    :items = "data"
   /> 
  <!-- <VDataTable  
     :headers="log_table.headers"
     :items="data"
     item-value="name" 
     :items-length="totalItems"
     :loading="loading"
     @update:options="loadItems"
   /> -->
  <Msgbox /> 
  <VCol cols="12">
    <VCard title="Customers" >  
      <VBtn 
        class="ml-auto addBtn" 
        @click="router.push({path:'/customers/add'})"
        >
        Add 
      </VBtn>  
     
      <VTable >
        <thead>
          <tr>
            <th class="text-uppercase"> Name </th> 
            <th> Tel</th>
            <th>payable</th>
            <th>receivable</th>
            <th>action</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="val, index in data"
            :key="val.id"
          >
            <td ><router-link :to="`/customers/view/${val.id}`" >{{ val.name }} </router-link>   </td>
            <td class="text-center"> {{ val.tel }} </td>
            <td class="text-center"> {{ val.payable }} </td>
            <td class="text-center"> {{ val.receivable }} </td>
            <td class="text-center"> 
              <VCardText class="py-3 px-4" > 
                  <VIcon size="30" color="primary" icon="bx-edit"  @click="edit(val.id)"/>
                
                  <VIcon size="30" color="error" icon="bx-trash" @click="remove(val.id, index)"/>
              </VCardText>
            </td>
          </tr>
        </tbody>
      </VTable> 
    </VCard>
  </VCol>  
  
</VRow>
  
</template>
