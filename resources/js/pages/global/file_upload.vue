<template>    
      <!-- <Msgbox/> -->
      <VCard title="Add File">
        <VForm @submit.prevent="(e)=>formSubmit(e)"   enctype="multipart/form-data"> 
          <VCardText class="d-flex"> 
            <div class="d-flex flex-column justify-center gap-5">
              <div class="d-flex flex-wrap gap-2">
                <VBtn
                  color="primary"
                  @click="refInputEl?.click();progress_value = 0;"
                >
                  <VIcon
                    icon="bx-cloud-upload"
                    class="d-sm-none"
                  />
                  <span class="d-none d-sm-block">Upload new file</span>
                </VBtn>

                <input 
                  ref="refInputEl"
                  type="file"
                  name="file"
                  accept=".jpeg,.png,.jpg,.pdf"
                  hidden
                  @input="changeInput"
                  multiple
                >

                <VBtn
                  type="reset"
                  color="error"
                  variant="tonal"
                  @click="resetInput"
                >
                  <span class="d-none d-sm-block">Reset</span>
                  <VIcon
                    icon="bx-refresh"
                    class="d-sm-none"
                  />
                </VBtn>
              </div>
              <p class="text-body-1 mb-0"  >
                Allowed JPG, GIF or PNG. Max size of 800K  
              </p> 
              <VCol v-if="myfiles">
                <ol>
                  <li v-for="file,index in myfiles" class="text-caption "> {{ file.name }} ({{ (file.size/1000000).toFixed(3) }}MB) </li>
                </ol>
                <VProgressLinear  :model-value="progress_value" class="mt-5"/>
              </VCol>
            </div>
          </VCardText>
        </VForm>
      </VCard> 
</template>

<script setup>  
import axios from 'axios';
import { ref } from 'vue';
let intialValues = {
  myfile: '',
  // title: '',
  description: '' ,
  ref_no: '',
  parent: ''
};
let form = ref({ ...intialValues })
let progress_value = ref(0)
 
  
 
const formData = { 
  description: '' ,
  ref_no: '',
  parent: ''
}
const refInputEl = ref()
const myfiles = ref()
 
// const parents = ['images','meeting','items','payments','staff','customers','company','categories','others']
const formDataLocal = ref(structuredClone(formData)) 
const emit = defineEmits(['change','update'])
const changeInput = file => {
  if(file.target.files.length>5){
    //store.setMsgbox({status:false,msg:"Maximum 5 files at a time please"});
    return false;
  }
  progress_value.value = 0;
  myfiles.value = (file.target.files);  
  progress_value.value = 100; 
  
  emit('files', myfiles.value)
}


const resetInput = () => {
  formDataLocal.value.myfile = formData.myfile
  progress_value.value = 0
}
 
const formSubmit = (e)=> {
  
  // console.log(myfiles.value)
    e.preventDefault(); 
    const config = {
      headers: {
          'content-type': 'multipart/form-data'
      }
    }
    let data = new FormData(); 
    data.append('description', formDataLocal.value.description); 
    data.append('ref_no', formDataLocal.value.ref_no); 
    data.append('parent', formDataLocal.value.parent); 

    Array.from(myfiles.value).forEach(file => {  
      data.append('upload_files[]', file);
    });
    axios.post('/api/upload/', data, config)
    .then(function (res) {
      if(res.data.success){   
        store.setMsgbox({status:true, msg:"Sucessfully Added"}); 
        Object.assign(form.value, intialValues); 
        // router.push({path: "/files"})
      } 
      else{
          store.setMsgbox({status:false, msg:"Failed to load data"}); 
      }
    })
    .catch(function (error) {
      store.setMsgbox({status:false, msg:error}); 
    });
}
</script> 

