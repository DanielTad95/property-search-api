<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Property Search</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .search-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }
        .page-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #303133;
        }
    </style>
</head>
<body>
    <div id="app" class="container">
        <el-card class="search-card" shadow="always">
            <div class="page-title">🏠 Property Search</div>
            
            <el-form @submit.prevent="searchProperties" label-position="top">
                <el-row :gutter="15">
                    <el-col :xs="24" :sm="12" :md="8">
                        <el-form-item label="Property Name">
                            <el-input 
                                v-model="searchParams.name" 
                                placeholder="Search by name..."
                                clearable
                            />
                        </el-form-item>
                    </el-col>
                    
                    <el-col :xs="24" :sm="12" :md="8">
                        <el-form-item label="Bedrooms">
                            <el-input-number 
                                v-model="searchParams.bedrooms" 
                                :min="1"
                                :max="10"
                                :step="1"
                                placeholder="Number of bedrooms"
                                style="width: 100%;"
                                controls-position="right"
                            />
                        </el-form-item>
                    </el-col>
                    
                    <el-col :xs="24" :sm="12" :md="8">
                        <el-form-item label="Bathrooms">
                            <el-input-number 
                                v-model="searchParams.bathrooms" 
                                :min="1"
                                :max="10"
                                :step="1"
                                placeholder="Number of bathrooms"
                                style="width: 100%;"
                                controls-position="right"
                            />
                        </el-form-item>
                    </el-col>
                    
                    <el-col :xs="24" :sm="12" :md="8">
                        <el-form-item label="Storeys">
                            <el-input-number 
                                v-model="searchParams.storeys" 
                                :min="1"
                                :max="5"
                                :step="1"
                                placeholder="Number of storeys"
                                style="width: 100%;"
                                controls-position="right"
                            />
                        </el-form-item>
                    </el-col>
                    
                    <el-col :xs="24" :sm="12" :md="8">
                        <el-form-item label="Garages">
                            <el-input-number 
                                v-model="searchParams.garages" 
                                :min="1"
                                :max="5"
                                :step="1"
                                placeholder="Number of garages"
                                style="width: 100%;"
                                controls-position="right"
                            />
                        </el-form-item>
                    </el-col>
                    
                    <el-col :xs="24" :sm="12" :md="8">
                        <el-form-item label="Min Price ($)">
                            <el-input-number 
                                v-model="searchParams.price_min" 
                                :min="0"
                                :step="10000"
                                placeholder="Minimum price"
                                style="width: 100%;"
                                controls-position="right"
                            />
                        </el-form-item>
                    </el-col>
                    
                    <el-col :xs="24" :sm="12" :md="8">
                        <el-form-item label="Max Price ($)">
                            <el-input-number 
                                v-model="searchParams.price_max" 
                                :min="0"
                                :step="10000"
                                placeholder="Maximum price"
                                style="width: 100%;"
                                controls-position="right"
                            />
                        </el-form-item>
                    </el-col>
                    
                    <el-col :xs="24" :sm="12" :md="8" style="display: flex; align-items: flex-end;">
                        <el-form-item style="width: 100%; margin-bottom: 0;">
                            <el-button 
                                type="primary" 
                                @click="searchProperties" 
                                :loading="loading"
                                style="width: 100%;"
                                size="large"
                            >
                                @{{ loading ? 'Searching...' : 'Search' }}
                            </el-button>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
        </el-card>

        <el-card class="search-card" v-if="loading" shadow="always">
            <div v-loading="loading" style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                <span style="font-size: 16px; color: #909399;">Searching properties...</span>
            </div>
        </el-card>

        <el-card class="search-card" v-if="!loading && searched && properties.length === 0" shadow="always">
            <el-empty description="No properties found. Try adjusting your search criteria.">
                <template #image>
                    <span style="font-size: 60px;">😔</span>
                </template>
            </el-empty>
        </el-card>

        <el-card class="search-card" v-if="!loading && properties.length > 0" shadow="always">
            <el-alert 
                :title="'Found ' + properties.length + (properties.length === 1 ? ' property' : ' properties')" 
                type="success" 
                :closable="false"
                style="margin-bottom: 20px;"
            />
            
            <el-table 
                :data="properties" 
                stripe
                style="width: 100%;"
            >
                <el-table-column label="Name" min-width="180">
                    <template #default="scope">
                        @{{ scope.row.name }}
                    </template>
                </el-table-column>
                <el-table-column label="Bedrooms" width="120" align="center">
                    <template #default="scope">
                        @{{ scope.row.bedrooms }}
                    </template>
                </el-table-column>
                <el-table-column label="Bathrooms" width="120" align="center">
                    <template #default="scope">
                        @{{ scope.row.bathrooms }}
                    </template>
                </el-table-column>
                <el-table-column label="Storeys" width="120" align="center">
                    <template #default="scope">
                        @{{ scope.row.storeys }}
                    </template>
                </el-table-column>
                <el-table-column label="Garages" width="120" align="center">
                    <template #default="scope">
                        @{{ scope.row.garages }}
                    </template>
                </el-table-column>
                <el-table-column label="Price" width="150" align="right">
                    <template #default="scope">
                        $@{{ formatPrice(scope.row.price) }}
                    </template>
                </el-table-column>
            </el-table>
        </el-card>
    </div>
</body>
</html>
