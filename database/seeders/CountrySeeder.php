<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = Country::updateOrCreate([
            'code' => 'BN',
            'name' => 'Bangladesh',
        ]);

        $states = [
            ['id' => '337', 'name' => 'Bagar Hat', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2022-03-16 18:09:52'],
            ['id' => '338', 'name' => 'Bandarban', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2022-03-16 18:09:53'],
            ['id' => '339', 'name' => 'Barguna', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:42:09'],
            ['id' => '340', 'name' => 'Barisal', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:18'],
            ['id' => '341', 'name' => 'Bhola', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:16'],
            ['id' => '342', 'name' => 'Bogora', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:15'],
            ['id' => '343', 'name' => 'Brahman Bariya', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:15'],
            ['id' => '344', 'name' => 'Chandpur', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:14'],
            ['id' => '345', 'name' => 'Chattagam', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:14'],
            ['id' => '346', 'name' => 'Chittagong Division', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:11'],
            ['id' => '347', 'name' => 'Chuadanga', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:11'],
            ['id' => '348', 'name' => 'Dhaka', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:10'],
            ['id' => '349', 'name' => 'Dinajpur', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:10'],
            ['id' => '350', 'name' => 'Faridpur', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:09'],
            ['id' => '351', 'name' => 'Feni', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:08'],
            ['id' => '352', 'name' => 'Gaybanda', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:32'],
            ['id' => '353', 'name' => 'Gazipur', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:31'],
            ['id' => '354', 'name' => 'Gopalganj', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:31'],
            ['id' => '355', 'name' => 'Habiganj', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:30'],
            ['id' => '356', 'name' => 'Jaipur Hat', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:30'],
            ['id' => '357', 'name' => 'Jamalpur', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:29'],
            ['id' => '358', 'name' => 'Jessor', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:29'],
            ['id' => '359', 'name' => 'Jhalakati', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:27'],
            ['id' => '360', 'name' => 'Jhanaydah', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:27'],
            ['id' => '361', 'name' => 'Khagrachhari', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:22'],
            ['id' => '362', 'name' => 'Khulna', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:23'],
            ['id' => '363', 'name' => 'Kishorganj', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:23'],
            ['id' => '364', 'name' => 'Koks Bazar', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:25'],
            ['id' => '365', 'name' => 'Cumilla', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 19:33:10'],
            ['id' => '366', 'name' => 'Kurigram', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:26'],
            ['id' => '367', 'name' => 'Kushtiya', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:47'],
            ['id' => '368', 'name' => 'Lakshmipur', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:46'],
            ['id' => '369', 'name' => 'Lalmanir Hat', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:45'],
            ['id' => '370', 'name' => 'Madaripur', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:45'],
            ['id' => '371', 'name' => 'Magura', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:44'],
            ['id' => '372', 'name' => 'Maimansingh', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:44'],
            ['id' => '373', 'name' => 'Manikganj', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:42'],
            ['id' => '374', 'name' => 'Maulvi Bazar', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:41'],
            ['id' => '375', 'name' => 'Meherpur', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:41'],
            ['id' => '376', 'name' => 'Munshiganj', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:36'],
            ['id' => '377', 'name' => 'Naral', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:36'],
            ['id' => '378', 'name' => 'Narayanganj', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:38'],
            ['id' => '379', 'name' => 'Narsingdi', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:39'],
            ['id' => '380', 'name' => 'Nator', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:39'],
            ['id' => '381', 'name' => 'Naugaon', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:40'],
            ['id' => '382', 'name' => 'Nawabganj', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:42:04'],
            ['id' => '383', 'name' => 'Netrakona', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:42:03'],
            ['id' => '384', 'name' => 'Nilphamari', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:42:03'],
            ['id' => '385', 'name' => 'Noakhali', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:42:02'],
            ['id' => '386', 'name' => 'Pabna', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:42:02'],
            ['id' => '387', 'name' => 'Panchagarh', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:42:00'],
            ['id' => '388', 'name' => 'Patuakhali', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:59'],
            ['id' => '389', 'name' => 'Pirojpur', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:58'],
            ['id' => '390', 'name' => 'Rajbari', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:58'],
            ['id' => '391', 'name' => 'Rajshahi', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:53'],
            ['id' => '392', 'name' => 'Rangamati', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:54'],
            ['id' => '393', 'name' => 'Rangpur', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:54'],
            ['id' => '394', 'name' => 'Satkhira', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:55'],
            ['id' => '395', 'name' => 'Shariatpur', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:56'],
            ['id' => '396', 'name' => 'Sherpur', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:57'],
            ['id' => '397', 'name' => 'Silhat', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:42:10'],
            ['id' => '398', 'name' => 'Sirajganj', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:42:11'],
            ['id' => '399', 'name' => 'Sunamganj', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:42:12'],
            ['id' => '400', 'name' => 'Tangayal', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:42:14'],
            ['id' => '401', 'name' => 'Thakurgaon', 'country_id' => $country->id, 'created_at' => '2021-04-06 07:11:20', 'updated_at' => '2023-06-15 12:41:18'],
        ];

        State::insert($states);

    }
}
