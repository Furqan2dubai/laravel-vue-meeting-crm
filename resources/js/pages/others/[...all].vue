<script setup>
import ErrorHeader from '@/components/ErrorHeader.vue';
import { UserStore } from '@/store/userStore.js';
import misc404 from '@images/pages/404.png';
import { useRouter } from 'vue-router';
const router = useRouter();
const store = UserStore();
let logout = ()=>{
    store.removeToken()
    router.push({path:'login'});
};
</script>

<template>
  <div class="misc-wrapper">
    <ErrorHeader
      error-code="404"
      error-title="Page Not Found ⚠️"
      error-description="We couldn't find the page you are looking for."
    />

    <!-- 👉 Image -->
    <div class="misc-avatar w-100 text-center">
      <VImg
        :src="misc404"
        alt="Coming Soon"
        :max-width="800"
        class="mx-auto"
      />
      <VBtn
        to="/"
        class="mt-10 mx-5"
      >
        Back to Home
      </VBtn>
      <VBtn
        @click="logout"
        class="mt-10 mx-5"
        color="error"
      >
        Logout
      </VBtn>
    </div>
  </div>
</template>

<style lang="scss">
@use "@core-scss/template/pages/misc.scss";
</style>
