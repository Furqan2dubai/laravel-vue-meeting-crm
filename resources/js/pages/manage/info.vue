<script setup>
import { UserStore } from '@/store/userStore.js';
import { hexToRgb } from '@layouts/utils';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useTheme } from 'vuetify';
const props = defineProps(['data'])
 
  const store = UserStore(); 
  const router = useRouter();  

  const filter = ref(props.data);
  const intial_data = {
    sales: 0,
    credits: 0,
    payments: 0,
    orders: 0
  }
  const data = ref(intial_data); 
  const load_data = ()=>{  
    if(filter.value.date=="" || filter.value.staff_id==""){
      return false;
    }
    axios.post("/api/get_info", { 
        staff_id: filter.value.staff_id,
        date: filter.value.date
    }).then(res=>{
      if(res.data.success){  
        data.value = res.data.data ? res.data.data : intial_data;    
        console.log(res.data.data)
      } 
      else{
          store.setMsgbox({status:false, msg:"Failed to load meeting data"}); 
      }
    }).catch(function (error) {
        store.setMsgbox({status:false, msg:error}); 
    });  
  }    
  onMounted(() => load_data());
  onUpdated(() => { 
    // filter.value.total_meeting = 0; 
    // data.value = [];
    load_data() ;
  }); 

  
const vuetifyTheme = useTheme()

const series = [
  45,
  80,
  20,
  40,
]

const chartOptions = computed(() => {
  const currentTheme = vuetifyTheme.current.value.colors
  const variableTheme = vuetifyTheme.current.value.variables
  const disabledTextColor = `rgba(${ hexToRgb(String(currentTheme['on-surface'])) },${ variableTheme['disabled-opacity'] })`
  const primaryTextColor = `rgba(${ hexToRgb(String(currentTheme['on-surface'])) },${ variableTheme['high-emphasis-opacity'] })`
  
  return {
    chart: {
      sparkline: { enabled: true },
      animations: { enabled: false },
    },
    stroke: {
      width: 6,
      colors: [currentTheme.surface],
    },
    legend: { show: false },
    tooltip: { enabled: false },
    dataLabels: { enabled: false },
    labels: [
      'Fashion',
      'Electronic',
      'Sports',
      'Decor',
    ],
    colors: [
      currentTheme.success,
      currentTheme.primary,
      currentTheme.secondary,
      currentTheme.info,
    ],
    grid: {
      padding: {
        top: -7,
        bottom: 5,
      },
    },
    states: {
      hover: { filter: { type: 'none' } },
      active: { filter: { type: 'none' } },
    },
    plotOptions: {
      pie: {
        expandOnClick: false,
        donut: {
          size: '75%',
          labels: {
            show: true,
            name: {
              offsetY: 17,
              fontSize: '14px',
              color: disabledTextColor,
              fontFamily: 'Public Sans',
            },
            value: {
              offsetY: -17,
              fontSize: '24px',
              color: primaryTextColor,
              fontFamily: 'Public Sans',
            },
            total: {
              show: true,
              label: 'Weekly',
              fontSize: '14px',
              formatter: () => '38%',
              color: disabledTextColor,
              fontFamily: 'Public Sans',
            },
          },
        },
      },
    },
  }
})

const orders = [
  {
    amount: '82.5k',
    title: 'Electronic',
    avatarColor: 'primary',
    subtitle: 'Mobile, Earbuds, TV',
    avatarIcon: 'bx-mobile-alt',
  },
  {
    amount: '23.8k',
    title: 'Fashion',
    avatarColor: 'success',
    subtitle: 'Tshirt, Jeans, Shoes',
    avatarIcon: 'bx-closet',
  },
  {
    amount: 849,
    title: 'Decor',
    avatarColor: 'info',
    subtitle: 'Fine Art, Dining',
    avatarIcon: 'bx-home',
  },
  {
    amount: 99,
    title: 'Sports',
    avatarColor: 'secondary',
    subtitle: 'Football, Cricket Kit',
    avatarIcon: 'bx-football',
  },
]

const reports = [
  { 
    title: 'Summary Reports',
    avatarColor: 'primary', 
    avatarIcon: 'bx-file',
    link: '#reports',
  },
  {
    title: 'Load Sheet',
    avatarColor: 'success', 
    avatarIcon: 'bx-file',
    link: '#reports',
  },
  { 
    title: 'Credit Sheet',
    avatarColor: 'info', 
    avatarIcon: 'bx-file',
    link: '#reports',
  },
  { 
    title: 'Balance Sheet',
    avatarColor: 'secondary', 
    avatarIcon: 'bx-file',
    link: '/staff/log',
  },
  { 
    title: 'Bulk meeting',
    avatarColor: 'red', 
    avatarIcon: 'bx-file',
    link: '#reports',
  },
]

const moreList = [
  {
    title: 'Share',
    value: 'Share',
  },
  {
    title: 'Refresh',
    value: 'Refresh',
  },
  {
    title: 'Update',
    value: 'Update',
  },
]
</script>

<template>
  <VCard>
    <VCardItem class="pb-3">
      <VCardTitle class="mb-1">
        Order Statistics
      </VCardTitle>
      <VCardSubtitle>{{data.orders || 0}} Total Sales</VCardSubtitle>

      <template #append>
        <div class="me-n3 mt-n8">
          <MoreBtn :menu-list="moreList" />
        </div>
      </template>
    </VCardItem>

    <VCardText>
      <VRow class="d-flex align-center justify-space-between mb-3">
        <VCol cols="6" md="2" >
          <h4 class="text-h4 mb-1">
            {{data.orders || 0}}
          </h4>
          <span>Total Orders</span>
        </VCol>

        <VCol cols="6" md="2">
          <h4 class="text-h4 mb-1">
            {{data.sales || 0}}
          </h4>
          <span>Total Sales</span>
        </VCol>

        <VCol cols="6" md="2">
          <h4 class="text-h4 mb-1">
            {{data.credits || 0}}
          </h4>
          <span>Total Credits</span>
        </VCol>

        <VCol cols="6" md="2">
          <h4 class="text-h4 mb-1">
            {{data.payments || 0}}
          </h4>
          <span>Total Payments</span>
        </VCol>

        <!-- <VCol cols="6" md="2">
          <VueApexCharts
            type="donut"
            :height="125"
            width="105"
            :options="chartOptions"
            :series="series"
          />
        </VCol> -->
      </VRow>

      
      <VList class="card-list mt-7" >
        <VListItem
          v-for="report in reports"
          :key="report.title"
        >
        
            <template #prepend>
              <VAvatar
                rounded
                variant="tonal"
                :color="report.avatarColor"
              >
                <VIcon :icon="report.avatarIcon" />
              </VAvatar> 
            </template>
            <a :href="`${report.link}/${filter.staff_id}/${filter.date}`">
              <VListItemTitle class="mb-1">
                {{ report.title }}
              </VListItemTitle>
              <VListItemSubtitle class="text-disabled">
                {{ report.subtitle }}
              </VListItemSubtitle> 
            </a>
        </VListItem>
      </VList>

      <!-- <VList class="card-list mt-7" >
        <VListItem
          v-for="order in orders"
          :key="order.title"
        >
          <template #prepend>
            <VAvatar
              rounded
              variant="tonal"
              :color="order.avatarColor"
            >
              <VIcon :icon="order.avatarIcon" />
            </VAvatar>
          </template>

          <VListItemTitle class="mb-1">
            {{ order.title }}
          </VListItemTitle>
          <VListItemSubtitle class="text-disabled">
            {{ order.subtitle }}
          </VListItemSubtitle>

          <template #append>
            <span>{{ order.amount }}</span>
          </template>
        </VListItem>
      </VList> -->
    </VCardText>
  </VCard>
  <span class="ms-5 position-absolute" style="visibility: hidden;">
    Page 1 - Data of {{ filter.staff }} on {{ filter.date }}
  </span>
</template>

<style lang="scss" scoped>
.card-list {
  --v-card-list-gap: 21px;
}
</style>
