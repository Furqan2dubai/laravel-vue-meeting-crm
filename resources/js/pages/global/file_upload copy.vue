<template>  
  <VRow>
    <VCol cols="12">
      <VCard title="Add File">
        <VForm @submit.prevent="(e)=>formSubmit(e)"   enctype="multipart/form-data"> 
 
          <VCardText class="d-flex">
            <!-- 👉 Avatar -->
            <VAvatar
              rounded="lg"
              size="100"
              class="me-6"
              :image="formDataLocal.myfile"
            />
            <div class="d-flex flex-column justify-center gap-5">
              <div class="d-flex flex-wrap gap-2">
                <VBtn
                  color="primary"
                  @click="refInputEl?.click()"
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
                >

                <VBtn
                  type="submit" 
                  variant="tonal" 
                >
                  <span class="d-none d-sm-block">Submit</span>
                  <VIcon
                    icon="bx-refresh"
                    class="d-sm-none"
                  />
                </VBtn>

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
            </div>

          </VCardText>
        </VForm>
      </VCard>
    </VCol>
  </VRow>
</template>

<script setup>
 import { UserStore } from '@/store/userStore.js';
const store = UserStore();
// store.setMsgbox({status:true,msg:"Success"});
// console.log("msg", store.msgbox.status); 
</script> 

