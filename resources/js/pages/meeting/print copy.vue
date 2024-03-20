
<script setup>
  import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRoute } from 'vue-router';
  const route = useRoute();
  const store = UserStore();
  let meeting = ref({});   
  const id = route.params.id;
  axios.get(`/api/meeting/${id}`).then(res=>{
    if(res.data.success){ 
        meeting.value = res.data.data ;  
        console.log(res.data.data)
      } 
      else{
          store.setMsgbox({status:false, msg:"Failed to load data"}); 
      }
  }).catch(function (error) {
      store.setMsgbox({status:false, msg:error}); 
  });   
 const print = ()=>{
  window.print();
 }
    // const k = route.params.id;
</script>

<template>  
<VRow >  
  <VCol class="d-flex">  
      <router-link to="/meeting" >
        <VBtn
          type="button"
          color="secondary"
          variant="tonal" 
        >
          Back
        </VBtn>
      </router-link> 
      <VBtn
        type="button"
        color="primary" 
        class="ml-auto"
        @click="print"
      >
        Print
      </VBtn>
      
  </VCol> 
  <VCol id="Meeting-print" cols="12" v-for="Meeting in meeting">
    <Msgbox class="mb-10"/>
    <VCard :title="`Meeting ${Meeting.Meeting_no}`">  
      <VCardText>  
        <h4 class="mt-5"> {{ Meeting.company_name }}</h4>
        <p class="mt-5" md="1"> 
          Unit 3A & 5, Giverny Walk,
          Jalan Sunsuria 3, Bandar Sunsuria, Cyberjaya,
          43900 Sepang, Selangor
          Malaysia
        </p>
        <p>  <b>Tel:</b> +60166441334 </p> 
        <p>  <b>Email:</b> management@laureapeoplessignature.com </p>  
        <VRow class="d-flex">
          <VDivider class="mt-5 mb-5"/>
          <VCol cols="6">
              <h4 class="mb-5">Bill to: {{Meeting.customer_name}}</h4>
              <p><b>Tel:</b> +60166441334 </p> 
              <p><b>Email:</b> management@laureapeoplessignature.com </p> 
            </VCol>
            <VCol cols="auto" class="ml-auto">
              <p><b>Meeting number:</b> {{Meeting.Meeting_no}} </p> 
              <p><b>Meeting date:</b> {{Meeting.Meeting_date}} </p> 
              <p><b>Due date:</b> {{Meeting.due_date}} </p> 
              <p><b>Payment terms:</b> {{Meeting.payment_terms}} </p> 
              <p><b>PO number:</b> {{Meeting.po_number}} </p> 
          </VCol>
          
          <VCol cols="12">
            <VTable >
              <thead>
                <tr>
                  <th class="text-uppercase"> Item </th>  
                  <th>Quantity</th>
                  <th>Unit Price</th>
                  <th>Subtotal</th>
                  <th>Discount</th>
                  <th>Tax</th>
                  <th>Nett</th>
                </tr>
              </thead>

              <tbody>
                <tr v-for="item in Meeting.items"> 
                  <td> 
                    <b>{{ item.name }} </b>
                    <h6 class="text-subtitle-2 text-no-wrap"> {{ item.description }} </h6>   
                  </td>   
                  <td class="text-center"> {{ item.quantity }} </td>   
                  <td class="text-center"> {{ item.unit_price }} </td>   
                  <td class="text-center"> {{ item.subtotal }} </td>   
                  <td class="text-center"> {{ item.discount }} </td>   
                  <td class="text-center"> {{ item.tax }} </td>   
                  <td class="text-center"> {{ item.net }} </td>   
                </tr>  
              </tbody>
            </VTable> 
          </VCol> 
          <VCol cols="7"> Note: {{ Meeting.note }} </VCol>

          <VCol cols="auto" class="ml-auto">
            <p>Subtotal Excluding Tax ({{Meeting.currency}}) {{Meeting.subtotal}} </p> 
            <p>Total Discount ({{Meeting.currency}}) {{Meeting.discount}} </p> 
            <p>Total SST Tax ({{Meeting.currency}}) {{Meeting.tax}} </p> 
            <p><b>Total Payable Nett ({{Meeting.currency}}) {{Meeting.total}}</b>  </p>  
          </VCol>
          <VCol cols="12">
            <p>Please make payment by any of the methods below: </p> 
            <p>Cheque in favour of <b>{{ Meeting.company_name }}</b>  </p> 
            <p>Online inter-bank transfer / GIRO transfer to <b>{{ Meeting.company_name }}</b> </p> 
            <p class="ml-5">Bank: <b>HSBC Amanah Malaysia</b>  </p>  
            <p class="ml-5">Bank account name: <b>{{ Meeting.company_name }}</b>  </p>  
            <p class="ml-5">Bank account number: <b>034129387021</b>  </p>  
            <p class="ml-5">SWIFT code: <b>HMABMYKL</b>  </p>  
          </VCol>
        </VRow>

      </VCardText>
    </VCard>
  </VCol>
  
</VRow>
  
</template>
