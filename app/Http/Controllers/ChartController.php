<?php

namespace App\Http\Controllers;

use App\Models\ProgramAttendance;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }
    public function overAllGender($male, $female)
    {
        return $this->chart->barChart()
            ->setTitle('Sex')
            ->setSubtitle('Total Gender')
            ->setLabels(['Male', 'Female'])
            ->addData('Total', [$male ?? 0, $female ?? 0])
            ->setHeight(200)
            ->setGrid();
    }
    public function civilStatus($single, $married, $widowed)
    {
        return $this->chart->pieChart()
            ->setTitle('Civil Status')
            ->setSubtitle('Total Civil Status')
            ->setLabels(['Single', 'Married', 'Widowed'])
            ->addData([$single, $married, $widowed])
            ->setWidth(260);
    }
    public function ageGap($sophomore, $junior, $senior)
    {
        return $this->chart->barChart()
            ->setTitle('Age')
            ->setSubtitle('Age Group')
            ->setLabels(['0 - 18', '19 - 65', '65+'])
            ->addData('Total', [$sophomore ?? 0, $junior ?? 0, $senior ?? 0])
            ->setHeight(200)
            ->setWidth(200)
            ->setGrid();
    }
    public function PWDStatus($active, $moved, $deceased)
    {
        return $this->chart->pieChart()
            ->setTitle('PWD Status')
            ->setSubtitle('Total count of PWD Status')
            ->setLabels(['Active', 'Moved', 'Deceased'])
            ->addData([$active, $moved, $deceased])
            ->setWidth(260);
    }
    public function disabilityType($disabilities)
    {
        return $this->chart->barChart()
            ->setTitle('Disability Type')
            ->setSubtitle('Different Type of Disabilities')
            ->setLabels(array_keys($disabilities))
            ->addData('Total PWD', array_values($disabilities))
            ->setWidth(500)
            ->setHeight(450)
            ->setGrid();
    }

    public function programTotalGender($male, $female)
    {
        return $this->chart->barChart()
            ->setTitle('Sex')
            ->setSubtitle('Total Gender Attended')
            ->setLabels(['Male', 'Female'])
            ->addData('Total', [$male ?? 0, $female ?? 0])
            ->setHeight(300)
            ->setGrid();
    }

    public function programTotalDisabilities($disabilities)
    {
        $disabilityCounts = array_count_values($disabilities);

        $data = array_values($disabilityCounts); // This will be the counts
        $labels = array_keys($disabilityCounts);

        return $this->chart->pieChart()
            ->setTitle('Disability Type')
            ->setSubtitle('Total Disability Type Attended')
            ->setLabels($labels)
            ->addData($data)
            ->setWidth(400)
            ->setHeight(400);
    }

    public function programBaranggay($baranggay, $count)
    {

        return $this->chart->barChart()
            ->setTitle('Baranggay')
            ->setSubtitle('Total person attended on each baranggay')
            ->setLabels($baranggay)
            ->addData('Attended', $count)
            ->setHeight(300)
            ->setGrid();
    }
    public function birthdayMonthGraph($data)
    {

        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        return $this->chart->barChart()
            ->setTitle('Birthday')
            ->setSubtitle('Total Persons with Disabilities (PWD) Celebrating Birthdays Each Month')
            ->setLabels($months)
            ->addData('Total: ', array_values($data))
            ->setGrid()
            ->setWidth(800)
            ->setHeight(400);
    }
    public function cashGiftStatus($data)
    {
        return $this->chart->barChart()
            ->setTitle('Status')
            ->setSubtitle('Status of cash gift for each PWD')
            ->setLabels(['Unreleased', 'Processing', 'Released'])
            ->addData('Total: ', $data)
            ->setGrid()
            ->setHeight(400);
    }
}
