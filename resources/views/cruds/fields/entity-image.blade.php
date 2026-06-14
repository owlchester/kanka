<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Entity $source
 * @var \App\Models\Campaign $campaign
 */

// The current image to display
$current = 'aaa';
?>
<entity-image 
    current="{{ $current }}"
    campaign="{{ $campaign->id }}"
>
</entity-image>
