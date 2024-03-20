
<script setup>
import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import avatar1 from '@images/avatars/avatar-1.png';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const store = UserStore();
// const route = useRoute();
const router = useRouter(); 
let intialValues = {
  myfile: avatar1,
  // title: '',
  description: '' ,
  ref_no: '',
  parent: '',
  added_by: store.user_id
};
let form = ref({ ...intialValues })
let progress_value = ref(0)
 
  
 
const formData = {
  // myfile: avatar1,
  // title: '',
  description: '' ,
  ref_no: '',
  parent: ''
}
const refInputEl = ref()
const myfiles = ref()
const parents = ['images','meeting','items','payments','staff','customers','company','categories','others']
const formDataLocal = ref(structuredClone(formData)) 

const changeAvatar = file => {
  if(file.target.files.length>5){
    store.setMsgbox({status:false,msg:"Maximum 5 files at a time please"});
    return false;
  }
  progress_value.value = 0;
  myfiles.value = (file.target.files);  
  progress_value.value = 100;
  // console.log(file,index) 

  // display image
  // const fileReader = new FileReader()
  // const { files } = file.target
  // if (files && files.length) {
  //   fileReader.readAsDataURL(files[0])
  //   fileReader.onload = () => {
  //     if (typeof fileReader.result === 'string')
  //       formDataLocal.value.myfile = fileReader.result
  //       progress_value.value = 100
  //   }
  // }
}

// reset avatar image
const resetAvatar = () => {
  formDataLocal.value.myfile = formData.myfile
  progress_value.value = 0
}
 
const formSubmit = (e)=> {
  
  console.log(myfiles.value)
    e.preventDefault(); 
    const config = {
        headers: {
            'content-type': 'multipart/form-data'
        }
    }
    let data = new FormData();
    // data.append('file_data', JSON.stringify(formDataLocal.value));
    // myfiles.value.forEach(file=>{
    //   data.append('upload_files[]', file);
    // })
    // data.append('title', formDataLocal.value.title); 
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
        router.push({path: "/files"})
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

<template>
  
  <VRow>  
    <Msgbox />  
    <VCol cols="12">
      <!-- 👉 Multiple Column -->
      <VCard title="Add File">
        <VForm @submit.prevent="(e)=>formSubmit(e)"   enctype="multipart/form-data"> 
          <VCardText class="d-flex">
            <!-- 👉 Avatar -->
            <!-- <VAvatar
              rounded="lg"
              size="100"
              class="me-6"
              :image="formDataLocal.myfile"
            /> -->
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
                  @input="changeAvatar"
                  multiple
                >

                <!-- <VBtn
                  type="submit" 
                  variant="tonal" 
                >
                  <span class="d-none d-sm-block">Submit</span>
                  <VIcon
                    icon="bx-refresh"
                    class="d-sm-none"
                  />
                </VBtn> -->

                <VBtn
                  type="reset"
                  color="error"
                  variant="tonal"
                  @click="resetAvatar"
                >
                  <span class="d-none d-sm-block">Reset</span>
                  <VIcon
                    icon="bx-refresh"
                    class="d-sm-none"
                  />
                </VBtn>
              </div>
              <p class="text-body-1 mb-0">
                Allowed JPG, GIF or PNG. Max size of 800K
              </p> 
              <VCol  v-if="myfiles">
                <ol>
                  <li v-for="file,index in myfiles" class="text-caption "> {{ file.name }} ({{ (file.size/1000000).toFixed(3) }}MB) </li>
                </ol>
                <VProgressLinear  :model-value="progress_value" class="mt-5"/>
              </VCol>
            </div>
          </VCardText>

          <VDivider />
          <VCardText> 
              <VRow> 
                   
                <VCol
                  cols="12"
                  md="4"
                >
                  <VTextField
                    v-model="formDataLocal.ref_no"
                    label="Reference No"
                    placeholder="INV 007" 
                  />
                </VCol>  

                
                <VCol
                  cols="12"
                  md="4"
                >
                
                  <VAutocomplete
                    v-model="formDataLocal.parent"
                    label="Parent"
                    placeholder="File Type"
                    :items="parents" 
                    return-object
                  />
                </VCol>

                <VCol
                  cols="12" 
                  md="12"
                >
                  <VTextarea  
                    v-model="formDataLocal.description"
                    label="Description"
                    placeholder="description"
                  />
                </VCol> 
                <VCol
                  cols="12"
                  class="d-flex gap-4"
                >
                <VBtn
                  type="submit" 
                  variant="tonal" 
                >
                  <span class="d-none d-sm-block">Add</span>
                  <VIcon
                    icon="bx-refresh"
                    class="d-sm-none"
                  />
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
            
          </VCardText>
        </VForm>
      </VCard>
    </VCol>
  </VRow> 
</template>
