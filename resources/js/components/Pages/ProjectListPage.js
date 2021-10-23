import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import axios from 'axios';
import Grid from '@mui/material/Grid';
import ProjectCard from '../Organisms/ProjectCard';

const ContainerGrid = styled(Grid)`
  width: 100%;
  height: 100%;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
`;

const ProjectListPage = () => {
  const [host, setHost] = useState('');
  const [data, setData] = useState([]);

  useEffect(()=> {
    setHost(location.host)
  }, [])

  useEffect(() => {
    if (host) {
      let url = `http://${host}/api/all_projejct` // ここのエンドポイントは適当だから検討
      axios.get(url).then(res => {
        setData(res.data)
        console.log(res.data)//データ取れてるはず
      });
    }
  }, [host])
  // サンプルデータ作成
  // 上のUseEffectでAPIを叩くと、同じ形で全プロジェクトのデータが帰って来ればそのまま使える。
  let sampleData = [
    {
      created_at: "2021-10-13 16:58:25",
      deleted_at: null,
      id: 1,
      language: "Swift",
      max_years_old: 30,
      men_and_women: "女性のみ",
      minimum_experience: 3,
      minimum_years_old: 18,
      number_of_application: 2,
      project_detail: "テスプロ詳細",
      project_name: "テスプロ",
      purpose: "学習",
      remarks: "テスプロ備考",
      status: 1,
      sub_language: "JavaScript",
      tools: "BitBucket",
      updated_at: "2021-10-13 16:58:25",
      work_frequency: null,
      year: "18歳~30歳",
      work_frequency: "週1~2時間",
      user_id: 1,
      user: {
        age: 20,
        comment: null,
        created_at: "2021-10-13 16:35:17",
        email: "test@test.com",
        email_verified_at: null,
        engineer_history: 1,
        free_url: null,
        friends_id: null,
        icon_image: null,
        id: 1,
        self_introduction: null,
        sex: 2,
        updated_at: "2021-10-13 16:35:17",
        user_name: "test" ,
      },
    },
    {
      created_at: "2021-10-16 13:48:17",
      deleted_at: null,
      id: 2,
      language: "GO",
      max_years_old: 18,
      men_and_women: "男性のみ",
      minimum_experience: 1,
      minimum_years_old: 16,
      number_of_application: 1,
      project_detail: "",
      project_name: "bbb",
      purpose: "学習",
      remarks: "",
      status: 1,
      sub_language: "Kotlin",
      tools: "GitLab",
      updated_at: "2021-10-16 13:48:17",
      work_frequency: null,
      year: "16歳~18歳",
      work_frequency: "週2~3日",
      user_id: 1,
      user: {
        age: 20,
        comment: null,
        created_at: "2021-10-13 16:35:17",
        email: "test@test.com",
        email_verified_at: null,
        engineer_history: 1,
        free_url: null,
        friends_id: null,
        icon_image: null,
        id: 1,
        self_introduction: null,
        sex: 2,
        updated_at: "2021-10-13 16:35:17",
        user_name: "test",
      },
    },
  ];

  return (
    <ContainerGrid>
      {
        sampleData.length &&
          sampleData.map((sampleData, index) => {
            return (
              <ProjectCard
                key={index}
                project_data={sampleData}
              />
            );
          })

      }
    </ContainerGrid>
  );
};

export default ProjectListPage;

ReactDOM.render(<ProjectListPage />, document.getElementById('project_list'));
