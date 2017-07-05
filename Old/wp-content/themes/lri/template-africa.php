<?php
/*
Template Name: Custom Africa Data JSON
*/

//	    $this->db->select('id, residence_country, sector, expertise_areas, experience_countries, languages, name, notes, cv');
if ( current_user_can('africa_database') ) {
function join_fields($fields){
    if(is_array($fields))
    return implode(', ', $fields);
    return $fields;
}

function get_cv_link($link){
    if($link){
        return "<a href=\"$link\">CV</a>";
    }
    return "N/A";
}

header("Content-Type: application/json");


$loop = new WP_Query( array( 'post_type' => 'africa_database', 'posts_per_page' => -1 ) );

$data = array();


while ( $loop->have_posts() ) : $loop->the_post();

    $data[] = array(
        'id' => get_the_ID(),
        'residence_country' => get_field('country_of_residence', get_the_ID()),
        'sector' => join_fields(get_field('sector', get_the_ID())),
        'expertise_areas' => join_fields(get_field('areas_of_expertise', get_the_ID())),
        'experience_countries' => join_fields(get_field('countries_with_experience', get_the_ID())),
        'languages' => join_fields(get_field('languages', get_the_ID())),
        'name' => get_the_title(),
        'notes' => strip_tags(get_the_content()),
        'cv' => get_cv_link(get_field('cv', get_the_ID()))
    );

endwhile;

echo json_encode($data);
} else {
    echo json_encode("Access denied!");
}