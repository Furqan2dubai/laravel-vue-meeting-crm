<script setup>
import avatar1 from '@images/avatars/avatar-1.png';
// furqan
import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
const store = UserStore();
const route = useRoute();
const router = useRouter(); 
const id = route.params.id || 1

axios.get("/api/companies/" + id).then(res=>{
  if(res.data.success){  
    accountDataLocal.value = res.data.data 
    store.setCompanyDetails(res.data.data) 
  } 
  else{
      store.setMsgbox({status:false, msg:"Failed to load data"}); 
  }
}).catch(function (error) {
    store.setMsgbox({status:false, msg:error}); 
}); 

const update = ()=>{ 
  const config = {
    headers: {
        'content-type': 'multipart/form-data'
    }
  }
  let data = new FormData(); 
  console.log(logo.value);
  if(logo.value.length){
    data.append('upload_files[]', logo.value[0]);
  }
  data.append('company_data', JSON.stringify(accountDataLocal.value));
  console.log(data);
  axios.post("/api/account/" + id, data, config).then(res=>{
    if(res.data.success){   
      store.setMsgbox({status:true, msg:"Sucessfully Updated"}); 
      store.setCompanyDetails(accountDataLocal.value) 
    } 
    else{
        store.setMsgbox({status:false, msg:"Failed to load data"}); 
    }
  }).catch(function (error) {
      store.setMsgbox({status:false, msg:error}); 
  }); 
}

//furqan end 

const accountData = {
  logo: avatar1,
  name: 'LAUREA PEOPLES SIGNATURE SDN BHD (202101030364)',
  tax_no: 'Doe',
  email: 'johnDoe@example.com',
  org: '',
  tel: '+1 (917) 543-9876',
  address: '123 Main St, New York, NY 10001',
  state: 'New York',
  zip: '10001',
  country: 'USA',
  language: 'English',
  // timezone: '(GMT-11:00) International Date Line West',
  currency: 'MYR',
  payment_detail: ''
}

const logo = ref(false) 
const refInputEl = ref()
const accountDataLocal = ref(structuredClone(accountData))
const isAccountDeactivated = ref(false)

const resetForm = () => {
  accountDataLocal.value = structuredClone(accountData)
}

const changeAvatar = file => {
  logo.value = file.target.files;
  const fileReader = new FileReader()
  const { files } = file.target
  if (files && files.length) {
    fileReader.readAsDataURL(files[0])
    fileReader.onload = () => {
      if (typeof fileReader.result === 'string')
        accountDataLocal.value.logo = fileReader.result
    }
  }
}

// reset avatar image
const resetAvatar = () => {
  accountDataLocal.value.logo = accountData.logo
}

const currencies = [
  'MYR',
  'USD',
  'EUR',
  'GBP',
  'AUD',
  'BRL',
  'CAD',
  'CNY',
  'CZK',
  'DKK',
  'HKD',
  'HUF',
  'PKR',
]



</script>

<template>
  <VRow>
    <Msgbox/>
    <VCol cols="12">
      <VCard title="Account Details">
        <VCardText class="d-flex">
          <!-- 👉 Avatar -->
          <VAvatar
            rounded="lg"
            size="100"
            class="me-6"
            :image="accountDataLocal.logo"
          />

          <!-- 👉 Upload Photo -->
          <form class="d-flex flex-column justify-center gap-5" enctype="multipart/form-data">
            <div class="d-flex flex-wrap gap-2">
              <VBtn
                color="primary"
                @click="refInputEl?.click()"
              >
                <VIcon
                  icon="bx-cloud-upload"
                  class="d-sm-none"
                />
                <span class="d-none d-sm-block">Upload new photo</span>
              </VBtn>

              <input
                ref="refInputEl"
                type="file"
                name="file"
                accept=".jpeg,.png,.jpg,GIF"
                hidden
                @input="changeAvatar" 
              >

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
          </form>
        </VCardText>

        <VDivider />

        <VCardText>
          <!-- 👉 Form -->
          <VForm class="mt-6">
            <VRow>
              <!-- 👉 First Name -->
              <VCol
                md="6"
                cols="12"
              >
                <VTextField
                  v-model="accountDataLocal.name"
                  placeholder="John"
                  label="Comapny Name"
                />
              </VCol>

              <!-- 👉 Last Name -->
              <VCol
                md="6"
                cols="12"
              >
                <VTextField
                  v-model="accountDataLocal.tax_no"
                  placeholder="Tax 007"
                  label="Tax No"
                />
              </VCol>

              <!-- 👉 Email -->
              <VCol
                cols="12"
                md="6"
              >
                <VTextField
                  v-model="accountDataLocal.email"
                  label="E-mail"
                  placeholder="johndoe@gmail.com"
                  type="email"
                />
              </VCol>

              <!-- 👉 Organization -->
              <VCol
                cols="12"
                md="6"
              >
                <VTextField
                  v-model="accountDataLocal.org"
                  label="Organization"
                  placeholder="Marketing Agency"
                />
              </VCol>

              <!-- 👉 Phone -->
              <VCol
                cols="12"
                md="6"
              >
                <VTextField
                  v-model="accountDataLocal.tel"
                  label="Phone Number"
                  placeholder="+1 (917) 543-9876"
                />
              </VCol>
 

              <!-- 👉 State -->
              <VCol
                cols="12"
                md="6"
              >
                <VTextField
                  v-model="accountDataLocal.state"
                  label="State"
                  placeholder="New York"
                />
              </VCol>

              <!-- 👉 Zip Code -->
              <VCol
                cols="12"
                md="6"
              >
                <VTextField
                  v-model="accountDataLocal.zip"
                  label="Zip Code"
                  placeholder="10001"
                />
              </VCol>

              <!-- 👉 Country -->
              <VCol
                cols="12"
                md="6"
              >
                <VSelect
                  v-model="accountDataLocal.country"
                  label="Country"
                  :items="['USA', 'Canada', 'UK', 'Malaysia','Singapore', 'Australia']"
                  placeholder="Select Country"
                />
              </VCol>

              <!-- 👉 Language -->
              <VCol
                cols="12"
                md="6"
              >
                <VSelect
                  v-model="accountDataLocal.language"
                  label="Language"
                  placeholder="Select Language"
                  :items="['English', 'Malay', 'Chinese', 'Arabic', 'Hindi', 'Urdu']"
                />
              </VCol>

              <!-- 👉 Timezone -->
              <!-- <VCol
                cols="12"
                md="6"
              >
                <VSelect
                  v-model="accountDataLocal.timezone"
                  label="Timezone"
                  placeholder="Select Timezone"
                  :items="timezones"
                  :menu-props="{ maxHeight: 200 }"
                />
              </VCol> -->

              <!-- 👉 Currency -->
              <VCol
                cols="12"
                md="6"
              >
                <VSelect
                  v-model="accountDataLocal.currency"
                  label="Default Currency"
                  placeholder="Select Currency"
                  :items="currencies"
                  :menu-props="{ maxHeight: 200 }"
                />
              </VCol>
              <!-- 👉 Address -->
              <VCol
                cols="12"
                md="12"
              >
                <VTextarea
                  v-model="accountDataLocal.address"
                  label="Address"
                  placeholder="123 Main St, New York, NY 10001"
                />
              </VCol>
              <!-- 👉 Payment Details -->
              <VCol
                cols="12"
                md="12"
              >
                <VTextarea
                  v-model="accountDataLocal.payment_detail"
                  label="Payment Details"
                  placeholder="HSBC ..."
                />
              </VCol>
              <!-- 👉 Form Actions -->
              <VCol
                cols="12"
                class="d-flex flex-wrap gap-4"
              >
                <VBtn @click="update">Save changes</VBtn>

                <VBtn
                  color="secondary"
                  variant="tonal"
                  type="reset"
                  @click.prevent="resetForm"
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
