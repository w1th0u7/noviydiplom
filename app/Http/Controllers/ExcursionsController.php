<?php

namespace App\Http\Controllers;

use App\Models\Excursion;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ExcursionsController extends Controller
{
    /**
     * Display the excursions page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Получаем экскурсии из базы данных
        
        $excursions = Excursion::all();
        
        if($excursions->isEmpty()) {
            $excursions = collect($this->getDemoExcursions());
        }
        
        // Группируем экскурсии по типу аудитории
        $preschoolExcursions = $excursions->filter(function($excursion) {
            return $excursion['audience_type'] === 'preschool' || $excursion['audience_type'] === 'all';
        });
        
        $schoolExcursions = $excursions->filter(function($excursion) {
            return $excursion['audience_type'] === 'school' || $excursion['audience_type'] === 'all';
        });
        
        $adultExcursions = $excursions->filter(function($excursion) {
            return $excursion['audience_type'] === 'adult' || $excursion['audience_type'] === 'all';
        });
        
        return view('excursions', compact('preschoolExcursions', 'schoolExcursions', 'adultExcursions'));
    }
    
    /**
     * Отобразить экскурсии для дошкольников
     *
     * @return \Illuminate\Http\Response
     */
    public function preschool()
    {
        $excursions = Excursion::getPreschoolExcursions();
        
        if($excursions->isEmpty()) {
            $excursions = collect($this->getDemoExcursions())->filter(function($excursion) {
                return $excursion['audience_type'] === 'preschool' || $excursion['audience_type'] === 'all';
            });
        }
        
        return view('excursions.preschool', compact('excursions'));
    }
    
    /**
     * Отобразить экскурсии для школьников
     *
     * @return \Illuminate\Http\Response
     */
    public function school()
    {
        $excursions = Excursion::getSchoolExcursions();
        
        if($excursions->isEmpty()) {
            $excursions = collect($this->getDemoExcursions())->filter(function($excursion) {
                return $excursion['audience_type'] === 'school' || $excursion['audience_type'] === 'all';
            });
        }
        
        return view('excursions.school', compact('excursions'));
    }
    
    /**
     * Отобразить экскурсии для взрослых
     *
     * @return \Illuminate\Http\Response
     */
    public function adult()
    {
        $excursions = Excursion::getAdultExcursions();
        
        if($excursions->isEmpty()) {
            $excursions = collect($this->getDemoExcursions())->filter(function($excursion) {
                return $excursion['audience_type'] === 'adult' || $excursion['audience_type'] === 'all';
            });
        }
        
        return view('excursions.adult', compact('excursions'));
    }
    
    /**
     * Отобразить детали конкретной экскурсии
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $excursion = Excursion::find($id);
        
        if(!$excursion) {
            // Для демонстрации используем демо данные
            $demoExcursions = collect($this->getDemoExcursions());
            $excursion = $demoExcursions->firstWhere('id', $id);
            
            if(!$excursion) {
                abort(404);
            }
        }
        
        return view('excursions.show', compact('excursion'));
    }
    
    /**
     * Получить демо-данные экскурсий, когда БД пуста
     *
     * @return array
     */
    public function getDemoExcursions()
    {
        return [
            [
                'id' => 1,
                'name' => 'Интерактивная экскурсия "В гостях у сказки"',
                'image' => 'img/excursions/4aWc5iIxL9V5cYYbJsdhZgKH82aK0BkzM7obT3kn.jpg',
                'location' => 'Александров',
                'region' => 'Центральный',
                'duration' => 2,
                'description' => 'Увлекательная экскурсия для дошкольников с играми, конкурсами и погружением в мир русских сказок.',
                'price' => 1200,
                'audience_type' => 'preschool',
                'min_age' => 3,
                'max_age' => 6,
                'available_seats' => 15,
                'features' => [
                    'Интерактивные игры',
                    'Аниматоры в костюмах',
                    'Мастер-класс по изготовлению игрушек',
                    'Чаепитие со сладостями'
                ]
            ],
            [
                'id' => 2,
                'name' => 'Образовательный тур "Старый город"',
                'image' => 'img/excursions/4aWc5iIxL9V5cYYbJsdhZgKH82aK0BkzM7obT3kn.jpg',
                'location' => 'Суздаль',
                'region' => 'Центральный',
                'duration' => 4,
                'description' => 'Погружение в историю древнего города. Экскурсия специально разработана для школьников с учетом школьной программы по истории.',
                'price' => 2000,
                'audience_type' => 'school',
                'min_age' => 7,
                'max_age' => 17,
                'available_seats' => 25,
                'features' => [
                    'Адаптированная под школьную программу',
                    'Посещение 3-х музеев',
                    'Интерактивные задания',
                    'Обед в кафе'
                ]
            ],
            [
                'id' => 3,
                'name' => 'Гастрономический тур "Вкусы России"',
                'image' => 'img/excursions/4aWc5iIxL9V5cYYbJsdhZgKH82aK0BkzM7obT3kn.jpg',
                'location' => 'Владимир',
                'region' => 'Центральный',
                'duration' => 6,
                'description' => 'Дегустационный тур с посещением лучших ресторанов и кафе города, знакомство с русской кухней и местными деликатесами.',
                'price' => 4500,
                'audience_type' => 'adult',
                'min_age' => 18,
                'max_age' => null,
                'available_seats' => 12,
                'features' => [
                    'Дегустация в 5 ресторанах',
                    'Мастер-класс от шеф-повара',
                    'Экскурсия на местную винодельню',
                    'Сувениры в подарок'
                ]
            ],
            [
                'id' => 4,
                'name' => 'Экскурсия "Царская резиденция"',
                'image' => 'img/excursions/4aWc5iIxL9V5cYYbJsdhZgKH82aK0BkzM7obT3kn.jpg',
                'location' => 'Александров',
                'region' => 'Центральный',
                'duration' => 3,
                'description' => 'Посещение Александровской слободы - царской резиденции Ивана Грозного. Экскурсия подходит для всех возрастов.',
                'price' => 1800,
                'audience_type' => 'all',
                'min_age' => null,
                'max_age' => null,
                'available_seats' => 30,
                'features' => [
                    'Осмотр исторических памятников',
                    'Адаптированная программа для любого возраста',
                    'Фотосессия в исторических костюмах',
                    'Сувенирная лавка'
                ]
            ],
            [
                'id' => 5,
                'name' => 'Природный тур "Заповедные места"',
                'image' => 'img/excursions/4aWc5iIxL9V5cYYbJsdhZgKH82aK0BkzM7obT3kn.jpg',
                'location' => 'Национальный парк Мещёра',
                'region' => 'Центральный',
                'duration' => 5,
                'description' => 'Экологическая экскурсия по заповеднику с изучением флоры и фауны. Подходит для всех возрастов.',
                'price' => 2500,
                'audience_type' => 'all',
                'min_age' => 5,
                'max_age' => null,
                'available_seats' => 20,
                'features' => [
                    'Наблюдение за дикой природой',
                    'Пикник на природе',
                    'Фотосессия',
                    'Сувениры из природных материалов'
                ]
            ],
            [
                'id' => 6,
                'name' => 'Музыкальное путешествие "Звуки природы"',
                'image' => 'img/excursions/4aWc5iIxL9V5cYYbJsdhZgKH82aK0BkzM7obT3kn.jpg',
                'location' => 'Детский музей',
                'region' => 'Центральный',
                'duration' => 1,
                'description' => 'Интерактивная экскурсия для дошкольников, знакомящая с музыкальными инструментами и звуками природы.',
                'price' => 800,
                'audience_type' => 'preschool',
                'min_age' => 3,
                'max_age' => 6,
                'available_seats' => 15,
                'features' => [
                    'Игра на музыкальных инструментах',
                    'Мастер-класс по изготовлению шумелок',
                    'Музыкальная сказка',
                    'Небольшой концерт'
                ]
            ],
        ];
    }
} 