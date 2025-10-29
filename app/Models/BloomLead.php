<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloomLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'flow_token',
        'phone_number',
        'client_name',
        'brand_name',
        'industry',
        'services',
        'budget',
        'goals',
        'timeline',
        'contact_method',
        'status',
        'tag',
        'raw_data',
        'completed_at'
    ];

    protected $casts = [
        'services' => 'array',
        'raw_data' => 'array',
        'completed_at' => 'datetime'
    ];

    public function isQualified()
    {
        return in_array($this->budget, ['300k_500k', '500k_1m', '1m_plus']);
    }

    public function getBudgetRangeAttribute()
    {
        $ranges = [
            '300k_500k' => '₦300,000 – ₦500,000',
            '500k_1m' => '₦500,000 – ₦1,000,000',
            '1m_plus' => '₦1,000,000+',
            'below_300k' => 'Below ₦300,000'
        ];

        return $ranges[$this->budget] ?? $this->budget;
    }

    public function getIndustryNameAttribute()
    {
        $industries = [
            'fashion_beauty' => 'Fashion & Beauty',
            'real_estate' => 'Real Estate',
            'tech_it' => 'Tech / IT',
            'food_beverage' => 'Food & Beverage',
            'ngo_foundation' => 'NGO / Foundation',
            'others' => 'Others'
        ];

        return $industries[$this->industry] ?? $this->industry;
    }
}
