<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Report extends Model
{
    public static function calculate($num_number,$num_end_number,$num_sym,$num_reverse,$num_price,$num_currency,$g_id,$var_sheet,$var_date)
    {

        $str = strlen($num_number);
        $price = 0;
        $total_price = 0;
        $end_price = 0;

        $check_pos = DB::table('tbl_pos_group')
            ->select(DB::raw('SUM(pos_two_digit) as total_two_digit'),DB::raw('SUM(pos_three_digit) as total_three_digit'))
            ->leftjoin('tbl_pos', 'tbl_pos_group.pos_id','=','tbl_pos.pos_id')
            ->where('tbl_pos_group.g_id',$g_id)
            ->where('tbl_pos.pos_time',$var_sheet)
            ->first();




//        condition 2 or 3 digit
        if($str=='2'){
            if($num_sym=='7'){
                // reverse number 29 *
                if($num_reverse=='1'){
                     $array = array_unique( str_split( $num_number ) );
					 $result = $array;
					 if(count($result)=='1'){
                         $total_price = $num_price;
                     }else{
                         $total_price = $num_price * 2;
                     }
                }else{
                    $total_price = $num_price;
                }

            }elseif($num_sym=='8'){
//              reverse number 22 -> 29 *
                if($num_reverse=='1'){
//                  number have number end
                    if($num_end_number){
                        $start = str_split($num_number);
                        $end = str_split($num_end_number);
                        // reverse number 20 -> 29 *
                        if($start[0]==$end[0] && $start[1]!=$end[1]){
                            for($i=$num_number; $i<=$num_end_number; $i++){
                                $result = array_unique( str_split( $i ) );
                                if(count($result)=='1'){
                                    $price = $num_price;
                                }elseif(count($result)=='2'){
                                    $price = $num_price * 2;
                                }
                                $total_price = $total_price + $price;
                            }
                        // reverse number 10 -> 90 *
                        }elseif($start[0]!=$end[0] && $start[1]==$end[1]){
                            for($i=$num_number; $i<=$num_end_number; $i=$i+10){
                                $result = array_unique( str_split( $i ) );
                                if(count($result)=='1'){
                                    $price = $num_price;
                                }elseif(count($result)=='2'){
                                    $price = $num_price * 2;
                                }
                                $total_price = $total_price + $price;
                            }

                        }
                    }else{
                        //  reverse number 23 -> *
                        // NO number have number end
                        $start = str_split($num_number);

                        for($i=$start[1]; $i<=9; $i++){
                            $result = array_unique( str_split( $num_number ) );
                            if(count($result)=='1'){
                                $price = $num_price;
                            }elseif(count($result)=='2'){
                                $price = $num_price * 2;
                            }
                            $num_number = $num_number + 1;
                            $total_price = $total_price + $price;
                        }
                    }
                }else{
                    //  reverse number 22 -> 29 *
                    //  number have number end
                    if($num_end_number){
                        $start = str_split($num_number);
                        $end = str_split($num_end_number);
                        if($start[0]==$end[0] && $start[1]!=$end[1]){
                            $total_price = $num_price *(($end[1]- $start[1]) + 1);
                        }elseif($start[0]!=$end[0] && $start[1]==$end[1]){
                            $total_price = $num_price *(($end[0]- $start[0]) + 1);
                        }else{
                            $total_price = $num_price *(($end[1]- $start[1]) + 1);
                        }
                    }else{
                        $last_num = substr($num_number, -1);
                        $total_price = $num_price *(10 - $last_num);
                    }
                }

            }elseif($num_sym=='9'){
                if($num_reverse=='1'){
//                  number have number end
                    if($num_end_number){
                        $start = str_split($num_number);
                        $end = str_split($num_end_number);
                        for($i=$num_number; $i<=$num_end_number; $i++){

                            $result = array_unique( str_split( $i ) );
                            if(count($result)=='1'){
                                $price = $num_price;
                            }elseif(count($result)=='2'){
                                $price = $num_price * 2;
                            }
                            $total_price = $total_price + $price;
                        }
                    }

                }else{
                    if($num_end_number){
                        $start = $num_number;
                        $end = $num_end_number;
                        $total_price = $num_price * (($end - $start) + 1);
                    }
                }
            }
        }elseif($str=='3'){
            if($num_sym=='7'){
                if($num_reverse=='1'){
                    $array = array_unique( str_split( $num_number ) );
                    $result = $array;
                    if(count($result)=='1'){
                        $total_price = $num_price;
                    }elseif(count($result)=='2'){
                        $total_price = $num_price * 3;
                    }elseif(count($result)=='3'){
                        $total_price = $num_price * 6;
                    }
                }else{
                    $total_price = $num_price;
                }
            }elseif($num_sym=='8'){
//              reverse number 223 -> *
                if($num_reverse=='1'){
//                  number have number end
                    if($num_end_number){
                        $start = str_split($num_number);
                        $end = str_split($num_end_number);
                        // reverse number 220 -> 229 *
                        if($start[0]==$end[0] && $start[1]==$end[1] && $start[2]!=$end[2]){
                            for($i=$num_number; $i<=$num_end_number; $i++){
                                $result = array_unique( str_split( $i ) );
                                if(count($result)=='1'){
                                    $price = $num_price;
                                }elseif(count($result)=='2'){
                                    $price = $num_price * 3;
                                }elseif(count($result)=='3'){
                                    $price = $num_price * 6;
                                }
                                $total_price = $total_price + $price;
                            }
                        // reverse number 230 -> 290 *
                        }elseif($start[0]==$end[0] && $start[1]!=$end[1] && $start[2]==$end[2]){
                            for($i=$num_number; $i<=$num_end_number; $i=$i+10){
                                $result = array_unique( str_split( $i ) );
                                if(count($result)=='1'){
                                    $price = $num_price;
                                }elseif(count($result)=='2'){
                                    $price = $num_price * 3;
                                }elseif(count($result)=='3'){
                                    $price = $num_price * 6;
                                }
                                $total_price = $total_price + $price;
                            }
                        // reverse number 330 -> 390 *
                        }elseif($start[0]!=$end[0] && $start[1]==$end[1] && $start[2]==$end[2]){
                            for($i=$num_number; $i<=$num_end_number; $i=$i+100){
                                $result = array_unique( str_split( $i ) );
                                if(count($result)=='1'){
                                    $price = $num_price;
                                }elseif(count($result)=='2'){
                                    $price = $num_price * 3;
                                }elseif(count($result)=='3'){
                                    $price = $num_price * 6;
                                }
                                $total_price = $total_price + $price;
                            }

                        }
                    }else{
                        //  NO reverse number 222 -> *
                        //  NO number have number end
                        $start = str_split($num_number);

                        for($i=$start[2]; $i<=9; $i++){
                            $result = array_unique( str_split( $num_number ) );
                            if(count($result)=='1'){
                                $price = $num_price;
                            }elseif(count($result)=='2'){
                                $price = $num_price * 3;
                            }elseif(count($result)=='3'){
                                $price = $num_price * 6;
                            }
                            $num_number = $num_number + 1;
                            $total_price = $total_price + $price;
                        }
                    }

                }else{
                    //  reverse number 222 ->
                    //  number have number end
                    if($num_end_number){
                        $start = str_split($num_number);
                        $end = str_split($num_end_number);
                        if($start[0]==$end[0] && $start[1]==$end[1] && $start[2]!=$end[2]){
                            $total_price = $num_price *(($end[2]- $start[2]) + 1);
                        }elseif($start[0]==$end[0] && $start[1]!=$end[1] && $start[2]==$end[2]){
                            $total_price = $num_price *(($end[1]- $start[1]) + 1);
                        }elseif($start[0]!=$end[0] && $start[1]==$end[1] && $start[2]==$end[2]){
                            $total_price = $num_price *(($end[0]- $start[0]) + 1);
                        }else{
                            $total_price = $num_price *(($end[0]- $start[0]) + 1);
                        }

                    }else{
                        $last_num = substr($num_number, -1);
                        $total_price = $num_price *(10 - $last_num);
                    }
                }
            }elseif($num_sym=='9'){
                if($num_reverse=='1'){
//                  number have number end
                    if($num_end_number){
                        $start = str_split($num_number);
                        $end = str_split($num_end_number);
                        for($i=$num_number; $i<=$num_end_number; $i++){

                            $result = array_unique( str_split( $i ) );
                            if(count($result)=='1'){
                                $price = $num_price;
                            }elseif(count($result)=='2'){
                                $price = $num_price * 3;
                            }elseif(count($result)=='3'){
                                $price = $num_price * 6;
                            }
                            $total_price = $total_price + $price;
                        }
                    }

                }else{
                    if($num_end_number){
                        $start = $num_number;
                        $end = $num_end_number;
                        $total_price = $num_price * (($end - $start) + 1);
                    }
                }
            }
        }

        if($str=='2'){
            $end_price = $total_price * $check_pos->total_two_digit;
        }elseif($str=='3'){
            $end_price = $total_price * $check_pos->total_three_digit;
        }

        $compare_result = Report::compare_result($num_number,$num_end_number,$num_sym,$num_reverse,$num_price,$num_currency,$g_id,$var_sheet,$var_date);


        return $end_price.'-'.$str.'-'.$compare_result;

    }

    public static function compare_result($num_number,$num_end_number,$num_sym,$num_reverse,$num_price,$num_currency,$g_id,$var_sheet,$var_date)
    {
        $count_win = 0;
        $check_pos = DB::table('tbl_pos_group')
            ->leftjoin('tbl_pos', 'tbl_pos_group.pos_id','=','tbl_pos.pos_id')
            ->join('tbl_result', 'tbl_pos_group.pos_id','=','tbl_result.pos_id')
            ->where('tbl_pos_group.g_id',$g_id)
            ->where('tbl_pos.pos_time',$var_sheet)
            ->where('tbl_result.re_date',$var_date)
            ->pluck('tbl_result.re_num_result')->all();
//        var_dump($check_pos);

        $str = strlen($num_number);
        // condition 2 or 3 digit
        if($str=='2'){ // condition 2 digit
            if($num_sym=='7'){

                if($num_reverse=='1'){

                    $array = str_split($num_number);
                    $number_re = Report::sampling($array,2);
                    foreach ($number_re as $number){
                        if($number <= 9){
                            $number = '0'.$number;
                        }
                        foreach ($check_pos as $check){
                            if((string)$number === $check){
                                $count_win++;
                            }
                        }

                    }

                }else {
                    if($num_number == 0){

                    }else if($num_number <= 9){
                        $num_number = '0'.$num_number;
                    }
                    foreach ($check_pos as $check){
                        if((string)$num_number === $check){
                            $count_win++;
                        }
                    }

                }
            }elseif($num_sym=='8'){

                if($num_reverse=='1'){

                    if($num_end_number){

                        $start = str_split($num_number);
                        $end = str_split($num_end_number);
                        // reverse number 20 -> 29 *
                        if($start[0]==$end[0] && $start[1]!=$end[1]){

                            for($i=$num_number; $i<=$num_end_number; $i++){
                                $array = str_split($i);
                                $number_re = Report::sampling($array,2);
                                foreach ($number_re as $number){
                                    if($number == 0) {

                                    }else if($number <= 9){
                                        $number = '0'.$number;
                                    }
                                    foreach ($check_pos as $check){
                                        if((string)$number === $check){
                                            $count_win++;
                                        }
                                    }

                                }
                            }
                            // reverse number 10 -> 90 *
                        }elseif($start[0]!=$end[0] && $start[1]==$end[1]){
                            for($i=$num_number; $i<=$num_end_number; $i=$i+10){
                                $array = str_split($i);
                                $number_re = Report::sampling($array,2);
                                foreach ($number_re as $number){
                                    if($number == 0) {

                                    }else if($number <= 9){
                                        $number = '0'.$number;
                                    }
                                    foreach ($check_pos as $check){
                                        if((string)$number === $check){
                                            $count_win++;
                                        }
                                    }

                                }
                            }

                        }elseif( $start[0]==$start[1] && $end[0]==$end[1] ){
                            for($i=$num_number; $i<=$num_end_number; $i=$i+11){
                                if($i == 0) {

                                }else if($i <= 9){
                                    $i = '0'.$i;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$i === $check){
                                        $count_win++;
                                    }
                                }
                            }

                        }
                    }else{
                        //  reverse number 23 -> *
                        // NO number have number end
                        $start = str_split($num_number);

                        for($i=$start[1]; $i<=9; $i++){

                            $array = str_split($num_number);
                            $number_re = Report::sampling($array,2);
                            foreach ($number_re as $number){
                                if($number == 0) {

                                }else if($number <= 9){
                                    $number = '0'.$number;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$number === $check){
                                        $count_win++;
                                    }
                                }

                            }

                            $num_number = $num_number + 1;
                        }
                    }

                }else{

                    if($num_end_number){
                        $start = str_split($num_number);
                        $end = str_split($num_end_number);
                        if($start[0]==$end[0] && $start[1]!=$end[1]){
                            for($i=$num_number; $i<=$num_end_number; $i++){
                                if($i == 0) {

                                }else if($i <= 9){
                                    $i = '0'.$i;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$i === $check){
                                        $count_win++;
                                    }
                                }

                            }

                        }elseif($start[0]!=$end[0] && $start[1]==$end[1]){

                            for($i=$num_number; $i<=$num_end_number; $i=$i+10){
                                if($i == 0) {

                                }else if($i <= 9){
                                    $i = '0'.$i;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$i === $check){
                                        $count_win++;
                                    }
                                }

                            }
                        }elseif( $start[0]==$start[1] && $end[0]==$end[1] ){
                            for($i=$num_number; $i<=$num_end_number; $i=$i+11){
                                if($i == 0) {

                                }else if($i <= 9){
                                    $i = '0'.$i;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$i === $check){
                                        $count_win++;
                                    }
                                }
                            }

                        }else{

                            for($i=$num_number; $i<=$num_end_number; $i++){
                                if($i == 0) {

                                }else if($i <= 9){
                                    $i = '0'.$i;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$i === $check){
                                        $count_win++;
                                    }
                                }
                            }

                        }
                    }else{
                        $last_num = substr($num_number, -1);
                        for($i=$last_num; $i<=9; $i++){
                            if($num_number == 0) {

                            }else if($num_number <= 9){
                                $num_number = '0'.$num_number;
                            }
                            foreach ($check_pos as $check){

                                if((string)$num_number === $check){
                                    $count_win++;
                                }
                            }
                            $num_number = $num_number + 1;

                        }

                    }
                }

            }elseif($num_sym=='9'){

                if($num_reverse=='1'){

                    if($num_end_number){

                        for($i=$num_number; $i<=$num_end_number; $i++){

                            $array = str_split($i);
                            $number_re = Report::sampling($array,2);
                            foreach ($number_re as $number){
                                if($number <= 9){
                                    $number = '0'.$number;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$number === $check){
                                        $count_win++;
                                    }
                                }

                            }

                        }
                    }

                }else{

                    if($num_end_number){
                        for($i=$num_number; $i<=$num_end_number; $i++){
                            if($i <= 9){
                                $i = '0'.$i;
                            }
                            foreach ($check_pos as $check){
                                if((string)$i === $check){
                                    $count_win++;
                                }
                            }
                        }
                    }

                }

            }
        }elseif($str=='3'){ // condition 3 digit
            if($num_sym=='7'){
                if($num_reverse=='1'){

                    $array = str_split($num_number);
                    $number_re = Report::sampling($array,3);
//                    var_dump($number_re);
                    foreach ($number_re as $number){
                        if($number == 0) {

                        }else if($number <= 9){
                            $number = '00'.$number;
                        }else if($number <= 99){
                            $number = '0'.$number;
                        }
                        foreach ($check_pos as $check){
                            if((string)$number === $check){
                                var_dump($check);
                                var_dump($number);
                                $count_win++;
                            }
                        }

                    }

                }else{
                    if($num_number == 0) {

                    }else if($num_number <= 9){
                        $num_number = '00'.$num_number;
                    }else if($num_number <= 99){
                        $num_number = '0'.$num_number;
                    }
                    foreach ($check_pos as $check){
                        if((string)$num_number === $check){
                            $count_win++;
                        }
                    }
                }
//                dd($count_win);
            }elseif($num_sym=='8'){

                if($num_reverse=='1'){
//                  number have number end
                    if($num_end_number){
                        $start = str_split($num_number);
                        $end = str_split($num_end_number);
                        // reverse number 220 -> 229 *
                        if($start[0]==$end[0] && $start[1]==$end[1] && $start[2]!=$end[2]){
                            for($i=$num_number; $i<=$num_end_number; $i++){

                                $array = str_split($i);
                                $number_re = Report::sampling($array,3);
                                foreach ($number_re as $number){
                                    if($number == 0) {

                                    }else if($number <= 9){
                                        $number = '00'.$number;
                                    }else if($number <= 99){
                                        $number = '0'.$number;
                                    }
                                    foreach ($check_pos as $check){
                                        if((string)$number === $check){
                                            $count_win++;
                                        }
                                    }
                                }

                            }
                            // reverse number 230 -> 290 *
                        }elseif($start[0]==$end[0] && $start[1]!=$end[1] && $start[2]==$end[2]){
                            for($i=$num_number; $i<=$num_end_number; $i=$i+10){

                                $array = str_split($i);
                                $number_re = Report::sampling($array,3);
                                foreach ($number_re as $number){
                                    if($number == 0) {

                                    }else if($number <= 9){
                                        $number = '00'.$number;
                                    }else if($number <= 99){
                                        $number = '0'.$number;
                                    }
                                    foreach ($check_pos as $check){
                                        if((string)$number === $check){
                                            $count_win++;
                                        }
                                    }
                                }

                            }
                            // reverse number 330 -> 390 *
                        }elseif($start[0]!=$end[0] && $start[1]==$end[1] && $start[2]==$end[2]){
                            for($i=$num_number; $i<=$num_end_number; $i=$i+100){

                                $array = str_split($i);
                                $number_re = Report::sampling($array,3);
                                foreach ($number_re as $number){
                                    if($number == 0) {

                                    }else if($number <= 9){
                                        $number = '00'.$number;
                                    }else if($number <= 99){
                                        $number = '0'.$number;
                                    }
                                    foreach ($check_pos as $check){
                                        if((string)$number === $check){
                                            $count_win++;
                                        }
                                    }
                                }

                            }
                        }elseif( ($start[0]==$start[1] && $start[1]==$start[2]) && ($end[0]==$end[1] && $end[1]==$end[2]) ){
                            for($i=$num_number; $i<=$num_end_number; $i=$i+111){
                                if($i == 0) {

                                }else if($i <= 9){
                                    $i = '00'.$i;
                                }else if($i <= 99){
                                    $i = '0'.$i;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$i === $check){
                                        $count_win++;
                                    }
                                }
                            }
                        }

                    }else{
                        //  NO reverse number 222 -> *
                        //  NO number have number end
                        $start = str_split($num_number);

                        for($i=$start[2]; $i<=9; $i++){

                            $array = str_split($num_number);
                            $number_re = Report::sampling($array,3);
                            foreach ($number_re as $number){
                                if($number == 0) {

                                }else if($number <= 9){
                                    $number = '00'.$number;
                                }else if($number <= 99){
                                    $number = '0'.$number;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$number === $check){
                                        $count_win++;
                                    }
                                }
                            }

                            $num_number = $num_number + 1;
                        }

                    }

                }else{
                    //  reverse number 222 ->
                    //  number have number end
                    if($num_end_number){
                        $start = str_split($num_number);
                        $end = str_split($num_end_number);
                        if($start[0]==$end[0] && $start[1]==$end[1] && $start[2]!=$end[2]){

                            for($i=$num_number; $i<=$num_end_number; $i++){
                                if($i == 0) {

                                }else if($i <= 9){
                                    $i = '00'.$i;
                                }else if($i <= 99){
                                    $i = '0'.$i;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$i === $check){
                                        $count_win++;
                                    }
                                }
                            }

                        }elseif($start[0]==$end[0] && $start[1]!=$end[1] && $start[2]==$end[2]){
                            for($i=$num_number; $i<=$num_end_number; $i=$i+10){
                                if($i == 0) {

                                }else if($i <= 9){
                                    $i = '00'.$i;
                                }else if($i <= 99){
                                    $i = '0'.$i;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$i === $check){
                                        $count_win++;
                                    }
                                }
                            }
                        }elseif($start[0]!=$end[0] && $start[1]==$end[1] && $start[2]==$end[2]){
                            for($i=$num_number; $i<=$num_end_number; $i=$i+100){
                                if($i == 0) {

                                }else if($i <= 9){
                                    $i = '00'.$i;
                                }else if($i <= 99){
                                    $i = '0'.$i;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$i === $check){
                                        $count_win++;
                                    }
                                }
                            }
                        }elseif( ($start[0]==$start[1] && $start[1]==$start[2]) && ($end[0]==$end[1] && $end[1]==$end[2]) ){
//                            var_dump($check_pos);
                            for($i=$num_number; $i<=$num_end_number; $i=$i+111) {
                                if($i == 0){

                                }else if($i <= 9){
                                    $i = '00'.$i;
                                }else if($i <= 99){
                                    $i = '0'.$i;
                                }

                                foreach ($check_pos as $check){
                                    if((string)$i === $check){

                                        $count_win++;
                                    }
                                }
                            }
                        }else{
                            for($i=$num_number; $i<=$num_end_number; $i++){
                                if($i == 0) {

                                }else if($i <= 9){
                                    $i = '00'.$i;
                                }else if($i <= 99){
                                    $i = '0'.$i;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$i === $check){
                                        $count_win++;
                                    }
                                }
                            }
                        }

                    }else{

                        $last_num = substr($num_number, -1);
                        for($i=$last_num; $i<=9; $i++){
                            if($num_number == 0) {

                            }else if($num_number <= 9){
                                $num_number = '00'.$num_number;
                            }else if($num_number <= 99){
                                $num_number = '0'.$num_number;
                            }
                            foreach ($check_pos as $check){
                                if((string)$num_number === $check){
                                    $count_win++;
                                }
                            }
                            $num_number = $num_number + 1;

                        }

                    }
                }

            }elseif($num_sym=='9'){

                if($num_reverse=='1'){

                    if($num_end_number){

                        for($i=$num_number; $i<=$num_end_number; $i++){

                            $array = str_split($i);
                            $number_re = Report::sampling($array,3);
                            foreach ($number_re as $number){
                                if($number == 0) {

                                }else if($number <= 9){
                                    $number = '00'.$number;
                                }else if($number <= 99){
                                    $number = '0'.$number;
                                }
                                foreach ($check_pos as $check){
                                    if((string)$number === $check){
                                        $count_win++;
                                    }
                                }
                            }

                        }

                    }

                }else{

                    if($num_end_number){

                        for($i=$num_number; $i<=$num_end_number; $i++){

                            if($i == 0) {

                            }else if($i <= 9){
                                $i = '00'.$i;
                            }else if($i <= 99){
                                $i = '0'.$i;
                            }
                            foreach ($check_pos as $check){
                                if((string)$i === $check){
                                    $count_win++;
                                }
                            }

                        }

                    }

                }

            }
        }

        return $count_win;
    }

    public static function sampling($chars, $size, $combinations = array()) {
        $resultDigit = array();
        if($size == 2){
            $resultDigit[] = $chars[0].$chars[1];
            $resultDigit[] = $chars[1].$chars[0];
        }else{
            $resultDigit[] = $chars[0].$chars[1].$chars[2];
            $resultDigit[] = $chars[0].$chars[2].$chars[1];
            $resultDigit[] = $chars[1].$chars[2].$chars[0];
            $resultDigit[] = $chars[1].$chars[0].$chars[2];
            $resultDigit[] = $chars[2].$chars[0].$chars[1];
            $resultDigit[] = $chars[2].$chars[1].$chars[0];
        }
        return  array_unique($resultDigit);
    }

}
