<script setup> 
  const meeting = defineProps(['data']);
  const print = ()=>{ 
    window.print();
  }

  const Meeting = [];
</script>

<template>    
    <VCard title="View Meeting">  
      <VCardText> 
        <VTable > 
          <tbody>
            <tr v-for="val,index in data['Meeting']">
              <td class=" text-uppercase"><code>{{ index.replace("_"," ") }}</code> </td>
              <td> {{ val }} </td>   
            </tr>  
             
          </tbody>
        </VTable> 
      </VCardText> 
      <!-- back btn -->
      <!-- <VCardText>  
          <router-link to="/staff" >
            <VBtn
              type="button"
              color="secondary"
              variant="tonal" 
            >
              Back
            </VBtn>
         </router-link> 
      </VCardText> -->
    </VCard> 
  
</template>
