
<script setup> 
  import axios from 'axios';
  const data = defineProps(['meeting']); 
  
  const print = ()=>{ 
    window.print(); 
  }

  const send_email = (id)=>{
    axios.get(`/api/meeting/email/${id}`).then(res=>{
      if(res.data.success){ 
          alert("email sent.") ; 
        } 
        else{
            store.setMsgbox({status:false, msg:"Failed to load data"}); 
        }
    }).catch(function (error) {
        store.setMsgbox({status:false, msg:error}); 
    });  
     
  }
  let company = JSON.parse(localStorage.getItem('company_details'));  
  
  
</script>

<template>    
    <VCard id="Meeting-print" v-if="data.meeting.Meeting " v-for="Meeting_data in data" :title="`Meeting No. ${Meeting_data.Meeting.Meeting_no}`"  >  
      <VCardText >  
        <VCol cols="9" class="px-0 ">
          <VImg :src="company.logo" width="100" height="auto" class="p-0 m-0"/>
          <h4 class="mt-5"> {{ company.name || Meeting_data.Meeting.company_name }}</h4>
          <p 
            class="mt-5 " 
            style="white-space: pre-wrap;" 
            v-html="company.address"
            >   
          </p>
          <p>  
            <b>Tel:</b> {{ company.tel }}  <br/>
            <b>Email:</b> {{company.email}} 
          </p>  
        </VCol >
        <VRow class="d-flex">
          <VDivider class="mt-5 mb-5"/>
          <VCol cols="6">
              <h4 class="mb-5">Bill to: {{Meeting_data.Meeting.customer_name}}</h4>
              <p>  
                <b>Address:</b> {{ Meeting_data.customer.address }}  <br/>
                <b>City:</b> {{ Meeting_data.customer.city }}  <br/>
                <b>State:</b> {{ Meeting_data.customer.state }}  <br/>
                <b>Tel:</b> {{ Meeting_data.customer.tel }}  <br/>
                <b>Email:</b> {{Meeting_data.customer.email}} 
              </p>   
            </VCol>
            <VCol cols="auto" class="ml-auto">
              <p>
                <b>Meeting number:</b> {{Meeting_data.Meeting.Meeting_no}} <br/>
                <b>Meeting date:</b> {{Meeting_data.Meeting.Meeting_date}} <br/>
                <b>Due date:</b> {{Meeting_data.Meeting.due_date}} <br/>
                <b>Payment terms:</b> {{Meeting_data.Meeting.payment_terms}} <br/>
                <b>PO number:</b> {{Meeting_data.Meeting.po_number}} 
              </p> 
          </VCol>
          
          <VCol cols="12">
            <VTable >
              <thead>
                <tr>
                  <th class="text-uppercase"> Item </th>  
                  <th>Quantity</th>
                  <th>Unit Price</th>
                  <th class="not-print">Subtotal</th>
                  <th class="not-print">Discount</th>
                  <th class="not-print">Tax</th>
                  <th>Nett</th>
                </tr>
              </thead>
  
              <tbody>
                <tr v-for="item in Meeting_data.items"> 
                  <td class="py-2"> 
                    <b>{{ item.name }} </b>
                    <p class="text-caption" max-width="1%" style="white-space: pre-wrap;">  {{ item.description }} </p>   
                  </td>   
                  <td class="text-center py-2"> {{ item.quantity }} {{ item.unit }} </td>   
                  <td class="text-center py-2"> {{ item.unit_price }} </td>   
                  <td class="text-center py-2 not-print"> {{ item.subtotal }} </td>   
                  <td class="text-center py-2 not-print"> {{ item.discount }} </td>   
                  <td class="text-center py-2 not-print"> {{ item.tax }} </td>   
                  <td class="text-center py-2"> <b>{{ item.net }}</b> </td>   
                </tr>  
              </tbody>
            </VTable> 
          </VCol> 
          <VCol cols="6" v-if="Meeting_data.Meeting.note"> Note: {{ Meeting_data.Meeting.note }} </VCol>
  
          <VCol cols="auto" class="ml-auto"> 
            <VRow cols="6" style="width: 300px;">
              <VCol cols="6"> 
                <p>Sub Total Excluding Tax </p> 
              </VCol> 
              <VCol cols="6">
                <p>RM {{Meeting_data.Meeting.subtotal}}</p>  
              </VCol>  
              <VCol cols="6"> 
                <p>Total Discount </p> 
              </VCol> 
              <VCol cols="6">
                <p>RM {{Meeting_data.Meeting.discount}}</p>  
              </VCol>  
        
              <VCol cols="6"> 
                <p>Total SST Tax </p> 
              </VCol> 
              <VCol cols="6">
                <p>RM {{Meeting_data.Meeting.total}}</p>  
              </VCol>  
              <VDivider/>
              <VCol cols="6">
                <b>Total Payable Nett </b>
              </VCol> 
              <VCol cols="6">
                <b>RM {{Meeting_data.Meeting.total}}</b> 
              </VCol>  
            </VRow> 
          </VCol>
          <VCol cols="12" > 
            <h4>Please make payment by any of the methods below:</h4>
            <p 
              v-html="company.payment_detail"
              style="white-space: pre-wrap;"
              >
            </p>
          </VCol>
        </VRow>
  
      </VCardText>
    </VCard> 
    <VCardText class="d-flex not-print position-absolute" style="bottom:10px;right:10px;">   
      <VBtn
        type="button" 
        color="#326f1e"     
        class="mr-5 email"
        @click="send_email(data.meeting.Meeting.id)"
      >
        Email
      </VBtn>
      <VBtn
        type="button"
        color="primary" 
        class="ml-auto"
        @click="print"
      >
        Print
      </VBtn>
    </VCardText>
  
</template>
