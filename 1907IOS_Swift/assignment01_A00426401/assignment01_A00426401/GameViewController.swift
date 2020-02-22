//
//  GameViewController.swift
//  assignment01_A00426401
//
//  Created by jiye wang on 2019-07-16.
//  Copyright © 2019 jiye wang. All rights reserved.
//

import UIKit

class GameViewController: UIViewController {

    @IBOutlet var contentview: UIView!
    @IBOutlet weak var moral_slider: UISlider!
    
    override func viewDidLoad() {
        super.viewDidLoad()
        set_black()
        // Do any additional setup after loading the view.
    }
    

    @IBAction func pressButton(_ sender: UIButton) {
        let number_press = Int(sender.tag)
        let number_left = number_press+1
        let number_top = number_press-10
        let number_bottom = number_press+10
        let number_right = number_press-1
        changeColor_red(number_press: number_left)
        changeColor_red(number_press: number_top)
        changeColor_red(number_press: number_bottom)
        changeColor_red(number_press: number_right)
        changeColor_red(number_press: number_press)
        check_red()
    }
    
    func changeColor_red(number_press: Int){
        contentview.subviews.forEach {
            if let button = $0.viewWithTag(number_press) as? UIButton {
                if button.backgroundColor != .red {
                    button.backgroundColor = .red
                }else{
                    button.backgroundColor = .black
                }
            }
        }
    }
    
    func set_black(){
        for i in 0...60 {
            contentview.subviews.forEach {
                if let button = $0.viewWithTag(i) as? UIButton{
                    if button.backgroundColor != .black{
                        button.backgroundColor = .black
                        button.tintColor = .white
                    }
                }
            }
        }
    }
    
    @IBAction func cheat(_ sender: UIButton) {
        let range = 8...
        if range.contains(Int(moral_slider.value)) {
            cheat_add()
            check_red()
        }else{
            let alert = UIAlertController(title: "Sorry, you can't!", message: "Your morality doesn't allow you to cheat!", preferredStyle: .alert)
            alert.addAction(UIAlertAction(title:"OK", style: .default,handler: nil))
            present(alert, animated: true, completion: nil)
        }
    }
    
    func cheat_add(){
        print("you cheat")
        for i in 1...60 {
            var countchange = 0
            contentview.subviews.forEach {
                if let button = $0.viewWithTag(i) as? UIButton{
                    if button.backgroundColor != .red {
                        button.backgroundColor = .red
                        countchange += 1
                    }
                }
            }
            if countchange == 1 {
                break
            }
        }
    }
    
    func check_red(){
        var count = 0
        for i in 0...60 {
            contentview.subviews.forEach {
                if let button = $0.viewWithTag(i) as? UIButton{
                    if button.backgroundColor == .red{
                        count += 1
                    }
                }
            }
        }
        print(count)
        if count == 36 {
            navigateTONextScreen()
        }
    }
    
    func navigateTONextScreen(){
        let storyBoard = UIStoryboard(name: "Main", bundle: nil)
        let viewController = storyBoard.instantiateViewController(withIdentifier:"ResultViewController")
        present(viewController, animated: true, completion: nil)
    }
    /*
    // MARK: - Navigation

    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        // Get the new view controller using segue.destination.
        // Pass the selected object to the new view controller.
    }
    */

}
