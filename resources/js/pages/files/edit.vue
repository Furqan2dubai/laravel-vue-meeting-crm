
<script setup>
import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
const store = UserStore();
const route = useRoute();
const router = useRouter(); 
let form = ref({
  title: '',
  description: '' ,
  parent: '', 
  ref_no: '',
  path:''
})
const id = route.params.id
const parents = ['images','meeting','items','payments','staff','customers','company','categories','others']

axios.get("/api/files/" + id).then(res=>{
  if(res.data.success){  
    form.value = res.data.data
    } 
    else{
        store.setMsgbox({status:false, msg:"Failed to load data"}); 
    }
}).catch(function (error) {
    store.setMsgbox({status:false, msg:error}); 
}); 

const update = ()=>{ 
  console.log(form.value)
  axios.post("/api/files/" + id, form.value).then(res=>{
  if(res.data.success){   
    store.setMsgbox({status:true, msg:"Sucessfully Updated"}); 
      } 
      else{
          store.setMsgbox({status:false, msg:"Failed to load data"}); 
      }
  }).catch(function (error) {
      store.setMsgbox({status:false, msg:error}); 
  }); 
}

</script>

<template>
  
  <VRow>  
    <Msgbox />  
    <VCol cols="12">
      <!-- 👉 Multiple Column -->
      <VCard title="Edit File">
        <VCardText>
          <VForm @submit.prevent="update"> 
            <VRow> 
              <VCol
              cols="12"
              md="3"
              >
                <VImg :src="form.path"  />
              </VCol>
              <VRow
                cols="9"
                md="9"
              >
                <VCol
                  cols="12"
                  md="4"
                >
                  <VTextField
                    v-model="form.title"
                    label="Title"
                    placeholder="Apple Image" 
                  />
                </VCol>
                <VCol
                  cols="12"
                  md="4"
                >
                  <VTextField
                    v-model="form.ref_no"
                    label="Reference No"
                    placeholder="INV 123" 
                  />
                </VCol>

                <VCol
                  cols="12"
                  md="4"
                >
                
                  <VAutocomplete
                    v-model="form.parent"
                    label="Parent"
                    placeholder="Search Parent"
                    :items="parents" 
                    readonly="true"
                  />
                </VCol>
  
                <VCol
                  cols="12"
                  md="12"
                >
                  <VTextarea
                    v-model="form.description"
                    label="Description"
                    placeholder="description"
                  />
                </VCol>
                

                <VCol
                  cols="12"
                  class="d-flex gap-4"
                >
                  <VBtn type="submit" class="ml-auto">
                    Update
                  </VBtn>

                  <VBtn
                    type="button"
                    color="secondary"
                    variant="tonal"
                    @click="router.push({path:'/files/'})"
                  >
                    Back
                  </VBtn>
                </VCol>
              </VRow>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow> 
</template>
