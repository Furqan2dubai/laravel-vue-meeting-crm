
<script setup>

import { UserStore } from '@/store/userStore.js';
import avatar1 from '@images/avatars/avatar-1.png';
import pages2 from '@images/pages/2.png';
const store = UserStore()
const form = ref({
  name : store.name,
  email : store.email,
  mobile : store.mobile,
  password : ''
}) 
const updateProfile = async()=> {
    await axios.post("/api/users/"+store.id, form.value).then(res=>{
        console.log(res);
        msg.value = res.data
        if(res.data.success){ 
            store.setToken(res.data.data.token, res.data.data.name);
            
            router.push({name:'/'});
        } 
    });
};
 
</script> 
<template>
  <VRow class="full-height">

    <VCol
      cols="12" 
      md="5"
    >
      <VCard>
        <VImg :src="pages2" />

        <VCardText class="position-relative">
          <!-- User Avatar -->
          <VAvatar
            size="75"
            class="avatar-center"
            :image="avatar1"
          />

          <!-- Title, Subtitle & Action Button -->
          <div class="d-flex justify-space-between flex-wrap pt-8">
            <div class="me-2 mb-2">
              <VCardTitle class="pa-0">
                {{form.name}}
              </VCardTitle>
              <VCardSubtitle class="text-caption pa-0">
                London, UK
              </VCardSubtitle>
            </div>
            <VBtn>Change Image</VBtn>
          </div>

          <!--  Mutual Friends -->
          <div class="d-flex justify-space-between align-center mt-4">
            <span class="font-weight-medium">18 mutual friends</span>

             
          </div>
        </VCardText>
      </VCard>
    </VCol>
    <VCol
        cols="12"
        md="7"
      >
        <!-- 👉 Vertical Form -->
        <VCard title="Profile">
          <VCardText>
            <VForm @submit.prevent="updateProfile">
              <VRow>
                <VCol cols="12">
                  <VTextField
                    v-model="form.name"
                    label="Name"
                    placeholder="John"
                  />
                </VCol>

                <VCol cols="12">
                  <VTextField
                    v-model="form.email"
                    label="Email"
                    type="email"
                    placeholder="johndoe@example.com"
                  />
                </VCol>

                <VCol cols="12">
                  <VTextField
                    v-model="form.mobile"
                    label="Mobile"
                    placeholder="+1 123 456 7890"
                    type="number"
                  />
                </VCol>

                <VCol cols="12">
                  <VTextField
                    v-model="form.password"
                    label="Password"
                    type="password"
                    placeholder="Leave empty if you do not want to change password"
                    messages="Leave empty if you do not want to change password"
                  />
                </VCol> 

                <VCol
                  cols="12"
                  class="d-flex gap-4"
                >
                  <VBtn type="submit">
                    Update
                  </VBtn>

                  <VBtn
                    type="reset"
                    color="secondary"
                    variant="tonal"
                  >
                    Reset
                  </VBtn>
                </VCol>
              </VRow>
            </VForm>
          </VCardText>
        </VCard>
      </VCol>
  </VRow>
</template>

