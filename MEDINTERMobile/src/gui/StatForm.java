/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import ServiceMedecin.MedecinService;
import com.codename1.charts.ChartComponent;
import com.codename1.charts.models.CategorySeries;
import com.codename1.charts.renderers.DefaultRenderer;
import com.codename1.charts.renderers.SimpleSeriesRenderer;
import com.codename1.charts.util.ColorUtil;
import com.codename1.charts.views.PieChart;
import com.codename1.components.SpanLabel;
import com.codename1.ui.Form;
import com.codename1.ui.layouts.BorderLayout;

/**
 *
 * @author BENJOU
 */
public class StatForm {
    /**
 * Creates a renderer for the specified colors.
 */
private DefaultRenderer buildCategoryRenderer(int[] colors) {
    DefaultRenderer renderer = new DefaultRenderer();
    renderer.setLabelsTextSize(28);
    renderer.setLegendTextSize(30);
    //renderer.setMargins(new int[]{20, 30, 15, 0});
    int k = 0;
    MedecinService ms = new MedecinService();
    String [] titles = ms.getStatTitles();
    for( k=0; k<titles.length; k++)
    { if(titles[k]==null){
    return renderer;
    }
        SimpleSeriesRenderer r = new SimpleSeriesRenderer();
        r.setColor(colors[k]);
        renderer.addSeriesRenderer(r);
    
    }
  
    return renderer;
}

/**
 * Builds a category series using the provided values.
 *
 * @param titles the series titles
 * @param values the values
 * @return the category series
 */
protected CategorySeries buildCategoryDataset(String title, double[] values) {
    CategorySeries series = new CategorySeries(title);
    int k = 0;
    MedecinService ms = new MedecinService();
    String [] titles = ms.getStatTitles();
    for( k=0; k<values.length; k++)
    { if(titles[k]==null){
    return series;
    }
        System.out.println("title = " + titles[k] + "value = " + values[k]);
       series.add(titles[k], values[k]);
        
    }

    return series;
}

public Form createPieChartForm() {
    // Generate the values
    MedecinService ms = new MedecinService();
    double[] values = ms.getStatValues();

    
    // Set up the renderer
    int[] colors = new int[]{ColorUtil.YELLOW, ColorUtil.BLUE, ColorUtil.GREEN, ColorUtil.CYAN, ColorUtil.MAGENTA};
    DefaultRenderer renderer = buildCategoryRenderer(colors);
    renderer.setZoomButtonsVisible(true);
    renderer.setZoomEnabled(true);
    renderer.setChartTitleTextSize(12);
    renderer.setDisplayValues(true);
    renderer.setShowLabels(true);
    SimpleSeriesRenderer r = renderer.getSeriesRendererAt(0);
    renderer.setLabelsColor(ColorUtil.BLACK);
    // Create the chart ... pass the values and renderer to the chart object.
    PieChart chart = new PieChart(buildCategoryDataset("Nombre des medecins Par specialité ", values), renderer);
  
    // Wrap the chart in a Component so we can add it to a form
    ChartComponent c = new ChartComponent(chart);
    
    // Create a form and show it.
    Form f = new Form();
    f.add(new SpanLabel("Nombre des medecins Par specialité"));
    f.add(c);
    return f;

}
}
