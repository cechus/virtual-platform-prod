<?php

namespace Muserpol;

use Illuminate\Database\Eloquent\Model;

class EconomicComplementSubmittedDocument extends Model
{
    protected $table = 'eco_com_submitted_documents';

    protected $fillable = [

        'economic_complement_id',
        'eco_com_requirement_id',
        'reception_date',
        'status',
        'comment'

    ];

    protected $guarded = ['id'];

    public function economic_complement_requirement()
    {
        return $this->belongsTo('Muserpol\EconomicComplementRequirement', 'eco_com_requirement_id');
    }

    public function economic_complement()
    {
        return $this->belongsTo('Muserpol\EconomicComplement');
    }

    public function scopeEconomicComplementIs($query, $id)
    {
        return $query->where('economic_complement_id', $id);
    }

}

EconomicComplementSubmittedDocument::created(function($ec_submittedDocument)
{
    Activity::createdEconomicComplementSubmittedDocument($ec_submittedDocument);

});

EconomicComplementSubmittedDocument::updated(function($ec_submittedDocument)
{
    Activity::updateEconomicComplementSubmittedDocument($ec_submittedDocument);

});
