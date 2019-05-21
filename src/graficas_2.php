<?php
    include ('jpgraph.php');
    include ('jpgraph_line.php');

    $datay1 = array(10,12,12,15,15,15,17,17,16,16,16,18);      //BAAP
    $datay2 = array(12,10,12,11,15,17,15,17,19,21,18,16);   //BAM
    $datay3 = array(6,6,6,6,6,6,4,4,4,2,2,2);               //BSAC
    $datay4 = array(19,19,22,24,24,25,20,20,20,22,22,23);   //BSBA

    // Setup the graph
    $graph = new Graph(900,350);
    $graph->SetScale("textlin");

    $theme_class=new UniversalTheme;
    
    // Graph title
    $graph->SetTheme($theme_class);
    $graph->img->SetAntiAliasing(false);
    $graph->title->Set('Students by Degree Program 2018');
    $graph->SetBox(false);

    $graph->img->SetAntiAliasing();

    $graph->yaxis->HideZeroLabel();
    $graph->yaxis->HideLine(false);
    $graph->yaxis->HideTicks(false,false);

    $graph->xgrid->Show();
    $graph->xgrid->SetLineStyle("solid");
    $graph->xaxis->SetTickLabels(array('Jan','Feb','Mar','Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'));
    $graph->xgrid->SetColor('#E3E3E3');

    // Create the first line
    $p1 = new LinePlot($datay1);
    $graph->Add($p1);
    $p1->SetColor("#6495ED");
    $p1->SetLegend('B.A. Applied Psych.');

    // Create the second line
    $p2 = new LinePlot($datay2);
    $graph->Add($p2);
    $p2->SetColor("#58b02b");
    $p2->SetLegend('B.A. in Management');

    // Create the third line
    $p3 = new LinePlot($datay3);
    $graph->Add($p3);
    $p3->SetColor("#FF1111");
    $p3->SetLegend('B.S. Applied Computing');

    // Create the fourth line
    $p4 = new LinePlot($datay4);
    $graph->Add($p4);
    $p4->SetColor("#15edff");
    $p4->SetLegend('B.S. in Business Admin.');

    $graph->legend->SetFrameWeight(1);      // Sets value for box width
    //$graph->Legend->Pos(center, bottom);    // Sets legend position

    // Output line
    $graph->Stroke();
?>