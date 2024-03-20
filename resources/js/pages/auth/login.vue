<script setup>
import { UserStore } from '@/store/userStore.js';
import AuthProvider from '@/views/pages/authentication/AuthProvider.vue';
import logo from '@images/logo.svg?raw';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const form = ref({
  email: '',
  password: '',
  remember: false,
})

const error = ref({status:false, msg:''});

const isPasswordVisible = ref(false)
  
  const router = useRouter();
  const store = UserStore(); 

  let msg = ref('');

  const login = async()=> {
      await axios.post("/api/login", form.value).then(res=>{
          msg.value = res.data
          if(res.data.success){ 
              error.value = {msg:'Successfully Login', status:false} 
              store.setToken(res.data.data.token, res.data.data.user)
              store.setCompanyDetails(res.data.data.company) 
              router.push({path:'/'});
            } 
            else{
              error.value = {msg:'Email or Password is incorrect', status:true}
            }
      });
  };
 
      
</script>

<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard
      class="auth-card pa-4 pt-7"
      max-width="448"
    >
      <VCardItem class="justify-center">
        <template #prepend>
          <div class="d-flex">
            <div
              class="d-flex text-primary"
              v-html="logo"
            />
          </div>
        </template>

        <VCardTitle class="text-2xl font-weight-bold">
          Meeting
        </VCardTitle>
      </VCardItem>

      <VCardText class="pt-2" >
        <h5 class="text-h5 mb-1">
          Welcome to LPS Meeting! 👋🏻
        </h5>
        <p class="mb-0">
          Please sign-in to your account and start the adventure
        </p>
      </VCardText>

      <VCardText>
        <VForm @submit.prevent="login" >
          <VRow>
            <!-- email -->
            <VCol cols="12">
              <VTextField
                v-model="form.email"
                autofocus
                placeholder="johndoe@email.com"
                label="Email"
                type="email"
                :error="error.status"
              />
            </VCol>

            <!-- password -->
            <VCol cols="12">
              <VTextField
                v-model="form.password"
                :error="error.status"
                :error-messages="error.status==true && error.msg"
                :messages="error.status==false && error.msg"
                label="Password"
                placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
              />

              <!-- remember me checkbox -->
              <div class="d-flex align-center justify-space-between flex-wrap mt-1 mb-4">
                <VCheckbox
                  v-model="form.remember"
                  label="Remember me"
                />

                <RouterLink
                  class="text-primary ms-2 mb-1"
                  to="javascript:void(0)"
                >
                  Forgot Password?
                </RouterLink>
              </div>

              <!-- login button -->
              <VBtn
                block
                type="submit" 
              >
                Login
              </VBtn>
            </VCol>

            <!-- create account -->
            <VCol
              cols="12"
              class="text-center text-base"
            >
              <span>New on our platform?</span>
              <RouterLink
                class="text-primary ms-2"
                to="/register"
              >
                Create an account
              </RouterLink>
            </VCol>

            <VCol
              cols="12"
              class="d-flex align-center"
            >
              <VDivider />
              <span class="mx-4">or</span>
              <VDivider />
            </VCol>

            <!-- auth providers -->
            <VCol
              cols="12"
              class="text-center"
            >
              <AuthProvider />
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/page-auth.scss";
</style>
