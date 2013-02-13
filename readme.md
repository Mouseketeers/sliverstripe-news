# Silverstripe news module

## The News Widget

To add the news widget to a page, place the following in its controller:

public function NewsWidget() {
    $widget = new NewsWidget();
    $widget->WidgetTitle = 'Our latest news';
    $widget->NumberToShow = 10;
    $widget->NoNewsMessage = 'Sorry, currently no news';
    return $widget->renderWith("WidgetHolder");
}

To include the news widget, add this to the template:
$NewsWidget