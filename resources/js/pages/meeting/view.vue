
<script setup>
import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import ViewMeeting from './ViewMeeting.vue';
  const route = useRoute();
  const store = UserStore();
  let data = ref({});   
  let files = ref({});  
  
  const id = route.params.id;
  axios.get(`/api/meeting/view/${id}`).then(res=>{
    if(res.data.success){ 
        data.value = res.data.data ; 
      } 
      else{
          store.setMsgbox({status:false, msg:"Failed to load data"}); 
      }
  }).catch(function (error) {
      store.setMsgbox({status:false, msg:error}); 
  });   
  const navigationTab = ref('Meeting')
</script>

<template>  
<!-- <VCard>` -->
  <VRow>  
    <Msgbox />   
    <VCol cols="12">
      <VTabs v-model="navigationTab"  >
        <VTab
          key="view"
          value="view"
        >
          View 
        </VTab>
         
        <VTab
          key="files"
          value="files"
        >
          files ({{ data.files && data.files.length }})
        </VTab>
      </VTabs>
      
      <VDivider />

      <!-- tabs content -->
      <VWindow v-model="navigationTab">
        <VWindowItem
          key="view"
          value="view" 
          >   
          <ViewMeeting :data="data" />
        </VWindowItem>
         
        <VWindowItem
          key="files"
          value="files"
          > 
          <VCard title="Attached Files">
            <VCardText> 
              <VCol v-if="data.files">
                <ol>
                  <li v-for="file,index in data.files" class="text-caption "> <a target="blank" :href="file.path"> {{ file.name }} </a> </li>
                </ol> 
              </VCol>
            </VCardText>
          </VCard>
        </VWindowItem>
      </VWindow>
    </VCol>  
    <VCol class="not-print">  
      <router-link to="/meeting" >
        <VBtn
          type="button"
          color="secondary"
          variant="tonal" 
        >
          Back
        </VBtn>
      </router-link>
    </VCol>
  </VRow>
<!-- </VCard> -->
  
</template>
